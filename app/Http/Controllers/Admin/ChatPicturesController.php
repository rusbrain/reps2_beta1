<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\{ PictureStoreRequest, PictureUpdateRequest};
use App\Services\Base\{BaseDataService, AdminViewService};
use App\Services\Chat\ChatPicturesService;
use App\Http\Controllers\Controller;
use App\ChatPicture;

class ChatPicturesController extends Controller
{
     /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.chat.pictures.list')->with(['pictures_count'=> ChatPicture::count(), 'request_data' => []]);
    }

    /**
     * Get chat pictures list paginate
     *
     * @return array
     */
    public function pagination()
    {
        $pictures = ChatPicture::with('file', 'user')->orderBy('updated_at', 'Desc')->paginate(20);
        return BaseDataService::getPaginationData(
            AdminViewService::getChatPictures($pictures), 
            AdminViewService::getPagination($pictures),
            AdminViewService::getChatPicturesPopUp($pictures)
        );
    
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        $charactor_arr = array();  
        $images = ChatPicture::all();
        foreach ($images as $image) {
            $charactor_arr[] = $image->charactor;
        }
        $gen   = $this->get_charactor($charactor_arr);
        return view('admin.chat.pictures.create')->with(['charactor'=>$gen]);       
    }

    /**
     * :image:
     */
    private function get_charactor($charactor_arr){
        $check = true;
        $gen = "";
        while($check){
            $gen   = ':cpic'. rand(1, 299) .':';
            if (!in_array($gen, $charactor_arr)) {
                $check = false;
            }
        }
        return $gen;
    }
    private function check_charactor($gen, $charactor_arr) 
    {        
        if (in_array($gen, $charactor_arr)) {
            return true;
        }
        return false;
    }

    /**
     * @param PictureStoreRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(PictureStoreRequest $request)
    {      
        $save = ChatPicturesService::store($request);
        return redirect()->route('admin.chat.pictures');
    }

     /**
     * @param $picture_id
     * @return mixed
     */
    private function getPictureObject($picture_id)
    {
        return ChatPicture::getpictureById($picture_id);
    }


    
    /**
     * @param $stream_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($picture_id)
    {
        return view('admin.chat.pictures.edit')->with(['picture'=> $this->getPictureObject($picture_id)]);
    }

    /**
     * @param PictureUpdateRequest $request
     * @param $picture_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PictureUpdateRequest $request, $picture_id)
    {
        $picture = ChatPicture::find($picture_id);

        if($picture){
            ChatPicturesService::update($request, $picture);
            return back();
        }
        return abort(404);
    }
    
    /**
     * @param $picture_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($picture_id)
    {
        ChatPicturesService::destroy(ChatPicture::find($picture_id));
        return back();       
    }
}
