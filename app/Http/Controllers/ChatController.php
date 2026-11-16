<?php

namespace App\Http\Controllers;

use App\Models\Katalog;
use App\Models\Pesan;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Halaman daftar chat pembeli.
     */
    public function index(Request $request)
    {
        if ($request->user()->role === 'penjual') {
            return redirect()->route('penjual.chat');
        }

        $userId = $request->user()->id_pengguna;
        $threads = $this->ambilPercakapan($userId);

        $q = trim($request->query('q', ''));

        if ($q !== '') {
            $threads = $threads->filter(function ($thread) use ($q) {
                return str_contains(
                    mb_strtolower($thread->nama_lawan_bicara),
                    mb_strtolower($q)
                ) || str_contains(
                    mb_strtolower($thread->barang->nama_barang ?? ''),
                    mb_strtolower($q)
                );
            })->values();
        }

        return view('chat.index', compact('threads', 'q'));
    }

    /**
     * Halaman inbox chat penjual.
     */
    public function inbox(Request $request)
    {
        $sellerId = $request->user()->id_pengguna;
        $threads = $this->ambilPercakapan($sellerId);

        $q = trim($request->query('q', ''));

        if ($q !== '') {
            $threads = $threads->filter(function ($thread) use ($q) {
                return str_contains(
                    mb_strtolower($thread->nama_lawan_bicara),
                    mb_strtolower($q)
                ) || str_contains(
                    mb_strtolower($thread->barang->nama_barang ?? ''),
                    mb_strtolower($q)
                );
            })->values();
        }

        $jumlahBelumDijawab = $threads->sum('jumlah_belum_dibaca');

        return view('chat.inbox', compact(
            'threads',
            'q',
            'jumlahBelumDijawab'
        ));
    }

    /**
     * Mengambil daftar percakapan berdasarkan pengguna dan barang.
     */
    private function ambilPercakapan($userId)
    {
        $pesanTerakhir = Pesan::where(function ($query) use ($userId) {
                $query->where('id_pengirim', $userId)
                    ->orWhere('id_penerima', $userId);
            })
            ->orderByDesc('waktu_kirim')
            ->orderByDesc('id_pesan')
            ->get()
            ->groupBy(function ($message) use ($userId) {
                $otherId = (int) $message->id_pengirim === (int) $userId
                    ? $message->id_penerima
                    : $message->id_pengirim;

                return $message->id_katalog . '-' . $otherId;
            })
            ->map(fn ($conversation) => $conversation->first())
            ->values();

        return $pesanTerakhir->map(function ($message) use ($userId) {
            $barang = Katalog::with(['penjual.pengguna', 'foto'])
                ->find($message->id_katalog);

            $otherId = (int) $message->id_pengirim === (int) $userId
                ? $message->id_penerima
                : $message->id_pengirim;

            $lawanBicara = Pengguna::find($otherId);

            $message->barang = $barang;
            $message->lawan_bicara = $lawanBicara;

            $message->nama_lawan_bicara = $lawanBicara?->nama ?? 'Pengguna';

            if ($barang?->penjual) {
                if ((int) $barang->penjual->id_pengguna === (int) $userId) {
                    $message->nama_lawan_bicara = $lawanBicara?->nama ?? 'Pembeli';
                } else {
                    $message->nama_lawan_bicara = $barang->penjual->nama_toko;
                }
            }

            $message->penerima_id = $otherId;

            $message->jumlah_belum_dibaca = Pesan::where(
                    'id_katalog',
                    $message->id_katalog
                )
                ->where('id_pengirim', $otherId)
                ->where('id_penerima', $userId)
                ->where('sudah_dibaca', false)
                ->count();

            $message->status_lawan_bicara = $lawanBicara?->status_akun ?? 'nonaktif';

            return $message;
        })->filter(fn ($thread) => $thread->barang !== null)
          ->values();
    }

    /**
     * Halaman detail percakapan.
     */
    public function show(Request $request, Katalog $katalog)
    {
        $katalog->load('penjual.pengguna', 'foto');

        $me = $request->user()->id_pengguna;
        $sellerId = $katalog->penjual?->id_pengguna;

        abort_unless($sellerId, 404);

        if ((int) $me === (int) $sellerId) {
            $other = (int) $request->query('with');

            abort_unless($other && Pesan::where('id_katalog', $katalog->id_katalog)
                ->where(function ($query) use ($me, $other) {
                    $query->where(function ($q) use ($me, $other) {
                        $q->where('id_pengirim', $me)
                          ->where('id_penerima', $other);
                    })->orWhere(function ($q) use ($me, $other) {
                        $q->where('id_pengirim', $other)
                          ->where('id_penerima', $me);
                    });
                })->exists(), 404);
        } else {
            abort_unless($katalog->status_katalog === 'aktif', 404);
            $other = $sellerId;
        }

        $lawanBicara = Pengguna::find($other);

        $messages = Pesan::where('id_katalog', $katalog->id_katalog)
            ->where(function ($query) use ($me, $other) {
                $query->where(function ($q) use ($me, $other) {
                    $q->where('id_pengirim', $me)
                      ->where('id_penerima', $other);
                })->orWhere(function ($q) use ($me, $other) {
                    $q->where('id_pengirim', $other)
                      ->where('id_penerima', $me);
                });
            })
            ->orderBy('waktu_kirim')
            ->orderBy('id_pesan')
            ->get();

        Pesan::where('id_katalog', $katalog->id_katalog)
            ->where('id_pengirim', $other)
            ->where('id_penerima', $me)
            ->where('sudah_dibaca', false)
            ->update(['sudah_dibaca' => true]);

        return view('chat.show', compact(
            'katalog',
            'messages',
            'other',
            'lawanBicara'
        ));
    }

    /**
     * Mengirim pesan.
     */
    public function send(Request $request, Katalog $katalog)
    {
        $request->validate([
            'isi_pesan' => 'required|string|max:2000',
        ]);

        $sellerId = $katalog->penjual()->value('id_pengguna');

        abort_unless($sellerId, 404);

        $me = $request->user()->id_pengguna;

        if ((int) $me === (int) $sellerId) {
            $recipient = (int) $request->input('penerima');

            abort_unless(
                $recipient &&
                Pesan::where('id_katalog', $katalog->id_katalog)
                    ->where(function ($query) use ($me, $recipient) {
                        $query->where(function ($q) use ($me, $recipient) {
                            $q->where('id_pengirim', $me)
                              ->where('id_penerima', $recipient);
                        })->orWhere(function ($q) use ($me, $recipient) {
                            $q->where('id_pengirim', $recipient)
                              ->where('id_penerima', $me);
                        });
                    })->exists(),
                403
            );
        } else {
            abort_unless($katalog->status_katalog === 'aktif', 404);
            $recipient = $sellerId;
        }

        abort_unless(
            $request->user()->status_akun === 'aktif',
            403,
            'Akun kamu sedang tidak aktif.'
        );

        Pesan::create([
            'id_katalog' => $katalog->id_katalog,
            'id_pengirim' => $me,
            'id_penerima' => $recipient,
            'isi_pesan' => $request->isi_pesan,
            'waktu_kirim' => now(),
            'sudah_dibaca' => false,
        ]);

        if ((int) $me === (int) $sellerId) {
            return redirect()->route('chat.show', [
                'katalog' => $katalog->id_katalog,
                'with' => $recipient,
            ]);
        }

        return redirect()->route('chat.show', $katalog->id_katalog);
    }
}
