<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.02.19
 * Time: 9:59
 */

namespace App\Services\Stream;

use App\{
   Stream,
   Services\Base\UserViewService,
   Services\User\UserService,
   User
};
use App\Http\Controllers\StreamController;
use App\Http\Requests\{
    StreamStoreRequest,
    StreamUpdateRequest
};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StreamService
{


    /**
     * @param StreamStoreRequest $request
     * @return mixed
     */
    public static function store(StreamStoreRequest $request)
    {
        $stream_data = $request->validated();
        $title = 'Stream ' . $request->has('title') ? $request->get('title') : '';
        $stream_data['user_id'] = Auth::id();

        if (UserService::isAdmin() ) {
            $stream_data['approved'] = 1;
        }

        $stream = Stream::create($stream_data);

        return $stream->id;
    }



    /**
     * @param StreamUpdateRequest $request
     * @return mixed
     */
    public static function updateStream(StreamUpdateRequest $request, Stream $stream)
    {
        $stream_data = $request->validated();

        if (!$request->has('approved')) {
            $stream_data['approved'] = "0";
        }

        Stream::where('id', $stream->id)->update($stream_data);
    }


}
