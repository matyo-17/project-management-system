<?php

namespace App\Lib;

class Utils {
    public static function array_equals(array $x, array $y): bool {
        return  !array_diff($x, $y) && !array_diff($y, $x);
    }

    public static function array_str_to_int(array $array): array {
        foreach ($array as $i => $e) {
            $array[$i] = (int) $e;
        }
        return $array;
    }
}
