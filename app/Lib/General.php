<?php

namespace App\Lib;

use App\Models\Invoices;
use Carbon\Carbon;

class General {
    public static function generate_invoice_number(): string {
        $today = Carbon::today();

        $date = $today->format("Ymd");
        $start = $today->format("Y-m-d 00:00:00");
        $end = $today->format("Y-m-d 23:59:59");

        $inv_cnt = Invoices::whereBetween("created_at", [$start, $end])
                            ->withTrashed()    
                            ->count();
        $number = str_pad((string) ($inv_cnt + 1), 6, "0", STR_PAD_LEFT);
        return "INV_".$date."_".$number;
    }
}
