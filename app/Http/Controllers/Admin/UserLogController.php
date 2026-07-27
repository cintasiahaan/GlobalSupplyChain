<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserLoginLog;
use Illuminate\Http\Request;

class UserLogController extends Controller
{
    public function index(Request $request)
    {
        $query = UserLoginLog::latest('logged_in_at');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('user_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $logs = $query->paginate(20)->withQueryString();
        $totalLogins = UserLoginLog::count();
        $uniqueUsersCount = UserLoginLog::distinct('user_id')->count('user_id');

        return view('admin.user-logs.index', compact('logs', 'totalLogins', 'uniqueUsersCount'));
    }
}
