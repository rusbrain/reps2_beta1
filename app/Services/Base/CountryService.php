<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.02.19
 * Time: 11:57
 */

namespace App\Services\Base;


use App\Country;
use App\Replay;
use App\User;

class CountryService
{
    /**
     * @param $type_id
     */
    public static function remove($type_id)
    {
        User::where('country_id', $type_id)->update(['country_id' => 0]);
        Replay::where('first_country_id', $type_id)->update(['first_country_id' => 0]);
        Replay::where('second_country_id', $type_id)->update(['second_country_id' => 0]);
        Country::where('id', $type_id)->delete();
    }
}