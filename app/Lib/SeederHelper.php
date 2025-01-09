<?php

namespace App\Lib;

use Carbon\Carbon;

class SeederHelper {
    public static function add_timestamps(array $data) {
        $now = Carbon::now();
        $data_len = count($data);

        for ($i=0; $i<$data_len; $i++) {
            $data[$i]["created_at"] = $now;
            $data[$i]["updated_at"] = $now;
        }
        return $data;
    }
}