<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Http\Requests\CountrySaveRequest;
use App\Http\Requests\RoleSaveRequest;
use App\Replay;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.country.list')->with(['country_count'=> Country::count(), 'request_data' => []]);
    }

    /**
     * Get user list paginate
     *
     * @return array
     */
    public function pagination()
    {
        $countries =Country::withCount('users', 'replays1', 'replays2')->paginate(50);

        $table      = (string) view('admin.country.list_table') ->with(['data' => $countries]);
        $pagination = (string) view('admin.user.pagination')    ->with(['data' => $countries]);
        $pop_up     = (string) view('admin.country.list_pop_up')->with(['data' => $countries]);

        return ['table' => $table, 'pagination' => $pagination, 'pop_up' => $pop_up];
    }

    /**
     * @param $type_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($type_id)
    {
        return view('admin.country.edit')->with('type', Country::find($type_id));
    }

    /**
     * @param CountrySaveRequest $request
     * @param $type_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(CountrySaveRequest $request, $type_id)
    {
        Country::where('id', $type_id)->update($request->validated());
        return back();
    }

    /**
     * @param $type_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($type_id)
    {
        User::where('country_id', $type_id)->update(['country_id' => 0]);
        Replay::where('first_country_id', $type_id)->update(['first_country_id' => 0]);
        Replay::where('second_country_id', $type_id)->update(['second_country_id' => 0]);

        Country::where('id', $type_id)->delete();

        return back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('admin.country.add');
    }

    /**
     * @param CountrySaveRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(CountrySaveRequest $request)
    {
        Country::create($request->validated());
        return back();
    }
}
