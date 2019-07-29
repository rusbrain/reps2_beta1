<?php

namespace App\Http\Controllers\Admin;

use App\Services\Base\AdminViewService;
use App\Services\Base\BaseDataService;
use App\Services\Base\UserActivityLogService;
use App\User;
use App\UserActivityLogEntry;
use Illuminate\Http\Request;

class UserActivityLogsController
{
    public function index(Request $request)
    {
        $request_data = $request->all();
        if (!isset($request_data['start'])) {
            $request_data['start'] = (new \DateTime())->format('Y-m-d');
        }
        if (!isset($request_data['end'])) {
            $request_data['end'] = (new \DateTime())->format('Y-m-d');
        }

        $selectedUser = null;
        if (isset($request_data['user_id'])) {
            $selectedUser = User::whereId($request_data['user_id'])->first();
        }

        return view('admin.user-activity-logs.index', ['request_data' => $request_data, 'selectedUser' => $selectedUser]);
    }

    public function pagination(Request $request)
    {
        $logs = UserActivityLogService::searchLogs($request)->paginate(50)->appends($request->all());
        return BaseDataService::getPaginationData(AdminViewService::getUserActivityLogs($logs), AdminViewService::getPagination($logs));
    }

    public function usersWithActivity(Request $request)
    {
        //if empty q gets last 20 users from activity log
        $query = $request->get('q');
        if (!$query) {
            $usersIds = UserActivityLogEntry::query()
                ->select('user_id')
                ->groupBy('user_id')
                ->limit(20)->pluck('user_id')->toArray();


            $users = User::query()->whereIn('id', $usersIds)->get();
        } else {
            //otherwise, try to find users by q
            $users = User::query()->where('name', 'like', "%$query%")->get();
        }

        return ['results' => $users->map(function($item) {
            return [
                'id' => $item->id,
                'text' => $item->name
            ];
        })->toArray()];
    }
}
