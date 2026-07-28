<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserLoginLog;
use Illuminate\Http\Request;

class UserLogController extends Controller
{
    public function index(Request $request)
    {
        // Strictly filter out any admin entries (by role, email, or name)
        $query = UserLoginLog::where('role', 'user')
            ->where('email', '!=', 'admin@gmail.com')
            ->where('user_name', 'not like', '%admin%')
            ->where('user_name', 'not like', '%Administrator%')
            ->latest('logged_in_at');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('user_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        $logs = $query->paginate(20)->withQueryString();

        $totalLogins = UserLoginLog::where('role', 'user')
            ->where('email', '!=', 'admin@gmail.com')
            ->where('user_name', 'not like', '%admin%')
            ->where('user_name', 'not like', '%Administrator%')
            ->count();

        $uniqueUsersCount = UserLoginLog::where('role', 'user')
            ->where('email', '!=', 'admin@gmail.com')
            ->where('user_name', 'not like', '%admin%')
            ->where('user_name', 'not like', '%Administrator%')
            ->distinct('user_id')
            ->count('user_id');

        return view('admin.user-logs.index', compact('logs', 'totalLogins', 'uniqueUsersCount'));
    }
}
