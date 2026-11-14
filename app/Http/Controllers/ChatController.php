<?php
namespace App\Http\Controllers;

use App\Models\{Katalog, Pesan, Pengguna};
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function inbox(Request $request)
    {
        $sellerId = $request->user()->id_pengguna;
        $latest = Pesan::where('id_pengirim',$sellerId)->orWhere('id_penerima',$sellerId)->orderByDesc('waktu_kirim')->get()
            ->groupBy(fn($message) => $message->id_katalog . '-' . ($message->id_pengirim == $sellerId ? $message->id_penerima : $message->id_pengirim))
            ->map(fn($conversation) => $conversation->first())->values();
        $threads = $latest->map(function ($message) use ($sellerId) {
            $message->barang = Katalog::find($message->id_katalog);
            $otherId = $message->id_pengirim == $sellerId ? $message->id_penerima : $message->id_pengirim;
            $message->lawan_bicara = Pengguna::find($otherId);
            $message->penerima_id = $otherId;
            return $message;
        });
        return view('chat.inbox', compact('threads'));
    }

    public function show(Request $request, Katalog $katalog)
    {
        $katalog->load('penjual.pengguna','foto');
        $me = $request->user()->id_pengguna;
        $sellerId = $katalog->penjual?->id_pengguna;
        abort_unless($sellerId, 404);
        if ($me === $sellerId) {
            $other = (int) $request->query('with');
            abort_unless($other && Pesan::where('id_katalog',$katalog->id_katalog)->where(function($q) use ($me,$other) {
                $q->where('id_pengirim',$me)->where('id_penerima',$other)->orWhere('id_pengirim',$other)->where('id_penerima',$me);
            })->exists(), 404);
        } else {
            abort_unless($katalog->status_katalog === 'aktif', 404);
            $other = $sellerId;
        }
        $messages = Pesan::where('id_katalog',$katalog->id_katalog)->where(function($q) use ($me,$other) {
            $q->where('id_pengirim',$me)->where('id_penerima',$other)->orWhere('id_pengirim',$other)->where('id_penerima',$me);
        })->orderBy('waktu_kirim')->get();
        Pesan::where('id_katalog',$katalog->id_katalog)->where('id_pengirim',$other)->where('id_penerima',$me)->update(['sudah_dibaca'=>true]);
        return view('chat.show', compact('katalog','messages','other'));
    }

    public function send(Request $request, Katalog $katalog)
    {
        $request->validate(['isi_pesan'=>'required|string|max:2000']);
        $sellerId = $katalog->penjual()->value('id_pengguna');
        abort_unless($sellerId, 404);
        $me = $request->user()->id_pengguna;
        if ($me === $sellerId) {
            $recipient = (int) $request->input('penerima');
            abort_unless($recipient && Pesan::where('id_katalog',$katalog->id_katalog)->where(function($q) use ($me,$recipient) {
                $q->where('id_pengirim',$me)->where('id_penerima',$recipient)->orWhere('id_pengirim',$recipient)->where('id_penerima',$me);
            })->exists(),403);
        } else {
            abort_unless($katalog->status_katalog === 'aktif', 404);
            $recipient = $sellerId;
        }
        Pesan::create(['id_katalog'=>$katalog->id_katalog,'id_pengirim'=>$me,'id_penerima'=>$recipient,'isi_pesan'=>$request->isi_pesan,'waktu_kirim'=>now(),'sudah_dibaca'=>false]);
        $url = route('chat.show', $katalog);
        if ($me === $sellerId) $url .= '?with=' . $recipient;
        return redirect($url);
    }
}
