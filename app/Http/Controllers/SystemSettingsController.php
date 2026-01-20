<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemSettingsController extends Controller
{
    /**
     * Show system settings
     */
    public function index()
    {
        $settings = SystemSetting::all();
        return view('admin.system-settings.index', compact('settings'));
    }

    /**
     * Update system settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string',
            'app_email' => 'required|email',
            'app_phone' => 'required|string',
            'app_timezone' => 'required|string',
        ]);

        foreach ($request->all() as $key => $value) {
            if ($key !== '_token' && $key !== '_method') {
                SystemSetting::updateOrCreate(
                    ['setting_key' => $key],
                    ['setting_value' => $value]
                );
            }
        }

        return redirect()->route('admin.system-settings.index')->with('success', 'Settings updated successfully');
    }
}
