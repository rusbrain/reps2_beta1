<?php

namespace App\Http\Controllers\Admin;

use App\Services\Base\AdminViewService;
use App\Services\Base\BaseDataService;
use App\Services\Base\UserActivityLogService;
use App\UserActivityLogEntry;
use Illuminate\Http\Request;

class UserActivityLogsController
{
    public function index(Request $request)
    {
        return view('admin.user-activity-logs.index', ['request_data' => $request->all()]);
    }

    public function pagination(Request $request)
    {
        $logs = UserActivityLogService::searchLogs($request)->paginate(50)->appends($request->all());
        return BaseDataService::getPaginationData(AdminViewService::getUserActivityLogs($logs), AdminViewService::getPagination($logs));
    }
}
