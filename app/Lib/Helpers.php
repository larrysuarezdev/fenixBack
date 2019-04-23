<?php

namespace App\Lib;

use DB as DB;

class Helpers {
    public static function hasActiveContract($user) {
        $contratosVigentes = DB::select('
            SELECT
                COUNT(1) AS c
            FROM
                inscripciones T0
            LEFT JOIN personas T1 ON
                T0.persona_id = T1.id
            LEFT JOIN users T2 ON
                T1.user_id = T2.id
            WHERE
                T0.status IN (?, ?)
                AND T2.id = ?', ['vigente', 'renovado', $user->id]);


        return $contratosVigentes[0]->c > 0;
    }
}