<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.02.19
 * Time: 10:54
 */

namespace App\Services\User;

use App\{File, User, UserFriend};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserService
{
    /**
     * Update user data profile
     *
     * @param Request $request
     * @param $user_id
     * @return mixed
     */
    public static function updateData(Request $request, $user_id)
    {
        $user      = User::find( $user_id);
        $user_data = $request->all();

        foreach ( $user_data as $key=>$item ){
            if ( is_null($item) ){
                unset($user_data[$key]);
            }
        }

        if ( isset( $user_data['country'] ) ){ // country_id
            $user_data['country_id'] = $user_data['country'];
            unset( $user_data['country'] );
        }

        if ( isset( $user_data['userbar'] ) ) {
            $user_data['userbar_id'] = $user_data['userbar'];
            unset( $user_data['userbar'] );
        }

        if ( $request->file('avatar') ){
            $title  = 'Аватар '.$user->name;
            $file   = File::storeFile ($request->file( 'avatar' ), 'avatars', $title );

            $user_data['file_id'] = $file->id;
        }

        if( Auth::user()->role ? ( Auth::user()->role->name != 'super admin' ) : true ){
            unset( $user_data['user_role_id'] );
        }

        $user->update( $user_data );
        return User::find( $user_id );
    }

    /**
     * Update user points
     *
     * @param $user_id
     * @param bool $point true - increment and false - decrement
     */
    public static function updatePoints($user_id, bool $point)
    {
        if($point){
            User::where('id', $user_id)->increment('points',1);
        } else{
            User::where('id', $user_id)->decrement('points',1);
        }
    }

    /**
     * Search users
     *
     * @param Request $request
     * @return User|\Illuminate\Database\Eloquent\Builder
     */
    public static function searchUser(Request $request)
    {
        $users = User::with('role','avatar', 'country')->withCount('topics', 'replays','user_galleries');

        if ($request->has('search') && null !==$request->get('search')){
            $users->where(function ($query) use ($request)
            {
                $query->where('id', $request->get('search'))
                    ->orWhere('name', 'like', '%'.$request->get('search').'%')
                    ->orWhere('email', 'like', '%'.$request->get('search').'%');
            });
        }

        if ($request->has('country') && null !==$request->get('country')){
            $users->where('country_id', $request->get('country'));
        }

        if ($request->has('email_verified') && null !==$request->get('email_verified')){
            if ($request->get('email_verified') == 0){
                $users->whereNull('email_verified_at');
            } else{
                $users->whereNotNull('email_verified_at');
            }
        }

        if ($request->has('role') && null !==$request->get('role')){
            $users->where('user_role_id', $request->get('role'));
        }

        if ($request->has('is_ban') && null !==$request->get('is_ban')){
            $users->where('is_ban', $request->get('is_ban'));
        }

        if($request->has('sort') && null !==$request->get('sort')){
            $users->orderBy($request->get('sort'));
        } else{
            $users->orderBy('created_at', 'desc');
        }

        return $users;
    }

    /**
     * Remove user
     *
     * @param User $user
     */
    public static function removeUser(User $user)
    {
        $user->user_galleries()->delete();
//        $user->dialogues()->delete();
        $user->user_friends()->delete();
        $user->user_friendly()->delete();

        User::where('id', $user->id)->update(array('email'=>'-'));
        User::where('id', $user->id)->delete();
    }

    /**
     * @return bool
     */
    public static function isAdmin()
    {
        if(Auth::user() && Auth::user()->role){
            if(Auth::user()->role->name == 'admin' || Auth::user()->role->name == 'super admin'){
                return true;
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public static function isModerator()
    {
        if(Auth::user() && Auth::user()->role){
            if(Auth::user()->role->name == 'moderator'){
                return true;
            }
        }
        return false;
    }

    public static function isFriendExists($user_id, $friend_user_id)
    {
        if(UserFriend::where('user_id', $user_id)->where('friend_user_id',$friend_user_id)->exists()){
            return true;
        }
        return false;
    }
}
