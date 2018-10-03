<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CensorshipWord extends Model
{
    private static $words;
    /**
     * Using table name
     *
     * @var string
     */
    protected $table='censorship_words';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'word'
    ];

    /**
     * Check text to censorship
     *
     * @param string $text
     * @return mixed|string
     */
    public static function check(string $text)
    {
        self::$words = self::$words??CensorshipWord::get(['word']);

        foreach (self::$words as $word){
            $text = str_ireplace($word->word, '[цензура]', $text);
        }

        return $text;
    }
}
