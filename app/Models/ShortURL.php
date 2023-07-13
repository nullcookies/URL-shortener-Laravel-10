<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ShortURL extends Model
{
    /**
     * @var array|string[]
     */
    public static array $alpha = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
    /**
     * @var bool
     */
    protected $guarded = false;

    /**
     * @var string
     */
    protected $table = 'short_urls';
    /**
     * @var string[]
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     *
     * @param string $value
     * @return string
     */
    public function getUrlKeyAttribute($value)
    {
        return route('shorten.url', $value);
    }

    /**
     * @return string
     */
    public static function getUrlKey()
    {
        $nextId = DB::table('short_urls')->max('id') + 1;
        return self::getColName($nextId);
    }

    /**
     * @param $index
     * @return string
     */
    public static function getColName($index)
    {
        $index--;
        $nAlphabets = 26;
        $f = floor($index / pow($nAlphabets, 0)) % $nAlphabets;
        $s = (floor($index / pow($nAlphabets, 1)) % $nAlphabets) - 1;
        $t = (floor($index / pow($nAlphabets, 2)) % $nAlphabets) - 1;

        $f = $f < 0 ? '' : self::$alpha[$f];
        $s = $s < 0 ? '' : self::$alpha[$s];
        $t = $t < 0 ? '' : self::$alpha[$t];

        return trim("{$t}{$s}{$f}");

    }
}
