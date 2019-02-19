<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.02.19
 * Time: 10:46
 */

namespace App\Services\Replay;

use App\Http\Requests\ReplayMapCreateAdminRequest;
use App\ReplayMap;
use Illuminate\Http\Request;

class ReplayMapService
{
    /**
     * @param Request $request
     * @param bool $query
     * @return bool
     */
    public static function search(Request $request, $query = false)
    {
        if (!$query){
            $query = ReplayMap::where('id', '>', 0);
        }

        if ($request->has('text') && $request->get('text')){
            $query->where(function ($q) use ($request){
                $q->where('id', 'like', "%{$request->get('text')}%")
                    ->orWhere('name', 'like', "%{$request->get('text')}%");
            });
        }

        if ($request->has('sort') && $request->get('sort')){
            $query->orderBy($request->get('sort'));
        }

        return $query;
    }

    /**
     * @param ReplayMapCreateAdminRequest $request
     */
    public static function createMap(ReplayMapCreateAdminRequest $request)
    {
        $data = $request->validated();

        $path = str_replace('public', '/storage',$data['file']->store('public/maps'));
        $data['url'] = $path;
        unset($data['file']);

        ReplayMap::create($data);
    }
}