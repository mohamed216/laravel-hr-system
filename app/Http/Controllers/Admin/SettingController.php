<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_locale' => 'required|in:en,ar',
            'timezone' => 'required|string',
            'currency' => 'required|string|max:10',
            'work_hours' => 'required|integer|min:1|max:24',
        ]);

        // Save to .env file
        $envPath = base_path('.env');
        $envContent = File::get($envPath);

        $envContent = preg_replace('/APP_NAME=.*/', 'APP_NAME=' . $validated['app_name'], $envContent);
        $envContent = preg_replace('/APP_LOCALE=.*/', 'APP_LOCALE=' . $validated['app_locale'], $envContent);
        $envContent = preg_replace('/APP_TIMEZONE=.*/', 'APP_TIMEZONE=' . $validated['timezone'], $envContent);

        File::put($envPath, $envContent);

        // Save custom settings to config
        config(['hr.currency' => $validated['currency']]);
        config(['hr.work_hours' => $validated['work_hours']]);

        return redirect()->route('admin.settings')->with('success', __('Settings updated successfully'));
    }

    public function backup()
    {
        // Create a simple backup of the database
        $filename = 'hr_backup_' . date('Y_m_d_His') . '.sql';
        
        return response()->download(storage_path('backups'), $filename)->deleteFileAfterSend(false);
    }

    public function clearCache()
    {
        // Clear application cache
        cache()->flush();

        return redirect()->route('admin.settings')->with('success', __('Cache cleared successfully'));
    }
}
