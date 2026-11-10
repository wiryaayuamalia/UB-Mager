<?php

use Illuminate\Support\Facades\Schedule;

// Batas bayar 10 menit (SYA-SR-30)
Schedule::command('pesanan:batal-kadaluarsa')->everyMinute();
