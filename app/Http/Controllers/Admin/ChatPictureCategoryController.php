<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\{ CategoryStoreRequest, CategoryUpdateRequest};
use App\Services\Base\{BaseDataService, AdminViewService};
use App\Services\Chat\ChatPicturesService;
use App\ChatPictureCategory;

class ChatPictureCategoryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.chat.pictures.categories.list')->with(['categories_count'=> ChatPictureCategory::count(), 'request_data' => []]);
    }

    /**
     * Get chat pictures categories list paginate
     *
     * @return array
     */
    public function pagination()
    {
        $categories = ChatPictureCategory::orderBy('id')->paginate(20);
        return BaseDataService::getPaginationData(
            AdminViewService::getChatPicturesCategory($categories), 
            AdminViewService::getPagination($categories),
            AdminViewService::getChatPicturesCategoryPopUp($categories)
        );    
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.chat.pictures.categories.create');       
    }

    /**
     * @param CategoryStoreRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(CategoryStoreRequest $request)
    {  
        $data = $request->validated();
        $category = ChatPictureCategory::create($data);
        return redirect()->route('admin.chat.pictures.category');
    }

    /**
     * @param $category_id
     * @return mixed
     */
    private function getCateObject($category_id)
    {
        return ChatPictureCategory::getCateById($category_id);
    }
    
    /**
     * @param $category_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($category_id)
    {
        return view('admin.chat.pictures.categories.edit')->with(['category'=> $this->getCateObject($category_id)]);
    }

    /**
     * @param CategoryUpdateRequest $request
     * @param $picture_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryUpdateRequest $request, $category_id)
    {
        $category = ChatPictureCategory::find($category_id);

        if($category){
            $data = $request->validated();    
            ChatPictureCategory::where('id', $category->id)->update($data);
            return redirect()->route('admin.chat.pictures.category');
        }
        return abort(404);
    }
    
    /**
     * @param $category_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($category_id)
    {
        $category = ChatPictureCategory::find($category_id);
        $category->delete();        
        return back();       
    }
}
