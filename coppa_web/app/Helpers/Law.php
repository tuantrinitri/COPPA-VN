<?php

namespace App\Helpers;

/**
 * summary
 */
class Law
{
    public static function listCatLaw()
    {
        return [
            [
                'id' => 1,
                'title' => 'Tư pháp'
            ],
            [
                'id' => 2,
                'title' => 'An ninh'
            ],
        ];
    }

    public static function listTypeLaw()
    {
        return [
            [
                'id' => 1,
                'title' => 'Quy định'
            ],
            [
                'id' => 2,
                'title' => 'Nghị định'
            ],
        ];
    }
}