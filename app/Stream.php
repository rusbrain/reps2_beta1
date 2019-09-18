<?php

namespace App;

use App\Traits\ModelRelations\StreamRelation;
use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    use StreamRelation;
    /**
     * Using table name
     *
     * @var string
     */

     /**
     * @var array
     */
    public static $races = [
        1 => 'All',
        2 => 'Z',
        3 => 'T',
        4 => 'P',
    ];
    public static $races_full = [
         'All' => 'Random',
         'Z' => 'Zerg',
         'T' => 'Terran',
         'P' => 'Protoss',
    ];

    public static $race_icons = [
        'All' => 'random.png',
        'Z' => 'zerg.gif',
        'T' => 'terran.gif',
        'P' => 'protoss.gif',
    ];
    protected $table='streams';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'title', 'race','content','country_id','stream_url', 'approved', 'is_parsed'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * @param $id
     * @return mixed
     */
    public static function getstreamById($id)
    {
        return Stream::where('id', $id)
            ->with('user.avatar')->first();
    }
}
