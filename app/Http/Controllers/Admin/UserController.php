<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Requests\User\PasswordRequestChange;
use App\Services\Base\{BaseDataService, AdminViewService};
use App\Services\User\UserService;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Get user list page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $users = UserService::searchUser($request);
        $users_count = $users->count();

        return view('admin.user.user_list')->with(['users_count' => $users_count, 'request_data' => $request->all()]);
    }

    /**
     * Get user list paginate
     *
     * @param Request $request
     * @return array
     */
    public function pagination(Request $request)
    {
        $users = UserService::searchUser($request)->paginate(50)->appends($request->all());
        return BaseDataService::getPaginationData(AdminViewService::getUsers($users), AdminViewService::getPagination($users));
    }

    /**
     * GEt user profile page
     *
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUserProfile($user_id)
    {
        return view('admin.user.profile')->with('user', User::getAllUserProfile($user_id));
    }

    /**
     * Get user edit profile page
     *
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEditUserProfile($user_id)
    {
        return view('admin.user.profile_edit')->with('user', User::getUserProfile($user_id));
    }

    /**
     * Save updated user data
     *
     * @param UpdateProfileRequest $request
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveUserProfile(UpdateProfileRequest $request, $user_id)
    {
        UserService::updateData($request, $user_id);
        return redirect()->route('admin.user.profile.edit', ['id' => $user_id]);
    }

    /**
     * Banning user
     *
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function banUser($user_id)
    {
        User::where('id', $user_id)->update(['is_ban' => 1]);
        return back();
    }

    /**
     * User permission
     *
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function notBanUser($user_id)
    {
        User::where('id', $user_id)->update(['is_ban' => 0]);
        return back();
    }

    /**
     * Soft delete user
     *
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeUser($user_id)
    {
        UserService::removeUser(User::find($user_id));
        return back();
    }

    /**
     * Change password on admin 
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword($user_id) {       
        return view('admin.user.change_password')->with('user', User::getUserProfile($user_id));
    }

    /**
     * Update password
     * @param PasswordRequestChange $request 
     * @return \Illuminat\Http\RedirectResponse
     * 
     */

    public function updatePassword(PasswordRequestChange $request) {

        $user = User::find($request->id);

        if (!Hash::check($request['old_password'], $user->password)){
            return back()->with('errors_password', 'Неверный пароль');
        }  

        try{
            $user->password=Hash::make($request['password']);
            $user->save();
            return back()->with('updated_password', 'Пароль успешно изменен');
        } catch (\Exception $e) {
            return back()->with('server_error', 'Ошибка сервера');
        }
    }
}