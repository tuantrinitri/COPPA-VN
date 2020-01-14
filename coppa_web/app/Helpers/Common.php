<?php

namespace App\Helpers;

/**
 * summary
 */
class Common
{
    public static function saveBase64ToImage($image, $record_id = '0') {
        // $path = base_path('public/data_sync/' . $path_info . '/');
        $path = base_path('public/data_sync/');
        //$base = $_REQUEST['image'];
        $base = $image;
        $binary = base64_decode($base);
        //$binary = base64_decode(urldecode($base));
        header('Content-Type: bitmap; charset=utf-8');

        $f = finfo_open();
        $mime_type = finfo_buffer($f, $binary, FILEINFO_MIME_TYPE);
        $mime_type = str_ireplace('image/', '', $mime_type);

        $filename = $record_id . '_' . md5(time()) . '.' . $mime_type;
        $file = fopen($path . $filename, 'wb');
        if (fwrite($file, $binary)) {
            return $filename;
        } else {
            return FALSE;
        }
        fclose($file);
    }
}