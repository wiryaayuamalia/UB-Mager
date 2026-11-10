<?php

namespace App\Console\Commands;

use App\Models\{Pesanan, Pembayaran, Katalog};
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BatalkanPesananKadaluarsa extends Command
{
    protected $signature = 'pesanan:batal-kadaluarsa';
    protected $description = 'Batalkan pesanan non-COD yang melewati batas bayar 10 menit & pulihkan stok';

    public function handle(): int
    {
        $list = Pesanan::where('status_pesanan', 'menunggu pembayaran')
            ->whereNotNull('batas_bayar')->where('batas_bayar', '<', now())->get();

        foreach ($list as $p) {
            DB::transaction(function () use ($p) {
                $p->update(['status_pesanan' => 'dibatalkan']);
                Pembayaran::where('id_pesanan', $p->id_pesanan)->update(['status_pembayaran' => 'dibatalkan']);
                Katalog::where('id_katalog', $p->id_katalog)->increment('stok');
            });
        }
        $this->info($list->count() . ' pesanan dibatalkan.');
        return self::SUCCESS;
    }
}
