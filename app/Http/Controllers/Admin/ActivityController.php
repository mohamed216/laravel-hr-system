<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        // In a real app, you'd have an activity_logs table
        // For now, we'll show a placeholder
        return view('admin.activity.index');
    }

    public static function log($action, $description)
    {
        Log::info('[' . auth()->user()->name . '] ' . $action . ': ' . $description);
    }
}
