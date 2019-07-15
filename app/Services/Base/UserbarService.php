<?php


namespace App\Services\Base;


class UserbarService
{
    protected static $items = [
        1 => 'arttosu.gif',
        2 => 'broodwar.gif',
        3 => 'broodwar_2.gif',
        4 => 'gosut.gif',
        5 => 'puser.gif',
        6 => 'starcraft.jpg',
        7 => 'starcraft_2.jpg',
        8 => 'starcraft_ghost.gif',
        9 => 'zuser.gif',
    ];

    public static function getItems()
    {
        return self::$items;
    }

    public static function getItemsIds()
    {
        return array_keys(self::$items);
    }
}
