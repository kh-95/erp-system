<?php

namespace App\Foundation\Classes;

use Carbon\Carbon;
use Illuminate\Http\Request;

class Helper
{
    const PAGINATION_LIMIT   = 10;
    const STORAGE_TYPE = 'public';
    const BASE_PATH = 'images';
    const BASE_FILE = 'files';
    const BASE_VIDEO = 'videos';
    const BASE_AUDIO = 'audios';
    const DEFAULT_IMAGE = 'default.jpg';


    public static function ConcatenateDateTime($date, $time, $timeFormat, $format = 'd-m-Y H:i')
    {
        if ($time) {
            return Carbon::parse($date . $time . $timeFormat)->format($format);
        }
        return null;
    }

    public static function getPaginationLimit(Request $request)
    {
        return $request->per_page ?? self::PAGINATION_LIMIT;
    }

    public static function generate_unique_code($model, $col = 'code', $length = 4, $letter_type = null)
    {
        $characters = '';
        switch ($letter_type) {
            case 'lower':
                $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                break;
            case 'upper':
                $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'numbers':
                $characters = '0123456789';
                break;

            default:
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
        }
        $generate_random_code = '';
        $charactersLength = strlen($characters);
        for ($i = 0; $i < $length; $i++) {
            $generate_random_code .= $characters[rand(0, $charactersLength - 1)];
        }
        if ($model::where($col, $generate_random_code)->exists()) {
            self::generate_unique_code($model, $col, $length, $letter_type);
        }
        return $generate_random_code;
    }
}
