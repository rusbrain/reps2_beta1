<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\QuickEmailRequest;
use App\Services\Base\BaseDataService;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * Get dashboard of Admin panel
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.dashboard')->with(BaseDataService::getAdminBaseData());
    }

    /**
     * Send quick email
     *
     * @param QuickEmailRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendQuickEmail(QuickEmailRequest $request)
    {
        BaseDataService::sendQuickEmail($request);
        return back()->with('status', 'Сообщение отправленно');
    }
}
