<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $settings = [
            'store_name' => Setting::get('store_name', 'Toko Budi'),
            'store_icon' => Setting::get('store_icon'),
        ];

        return view('pages.settings.index', compact('settings'));
    }

    /**
     * Update the store settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'store_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update store name
        Setting::set('store_name', $request->store_name);
        
        // Update app name in config (for current request only)
        config(['app.name' => $request->store_name]);

        // Handle icon removal if requested
        if ($request->has('remove_icon') && $request->remove_icon == '1') {
            $oldIcon = Setting::get('store_icon');
            if ($oldIcon && Storage::disk('s3')->exists($oldIcon)) {
                Storage::disk('s3')->delete($oldIcon);
            }
            Setting::set('store_icon', null);
        }
        // Update store icon if provided
        elseif ($request->hasFile('store_icon')) {
            // Delete old icon if exists
            $oldIcon = Setting::get('store_icon');
            if ($oldIcon && Storage::disk('s3')->exists($oldIcon)) {
                Storage::disk('s3')->delete($oldIcon);
            }

            // Store new icon to S3
            $iconPath = $request->file('store_icon')->store('store', 's3');
            Setting::set('store_icon', $iconPath);
        }

        // Clear the view cache to ensure new settings are applied
        if (function_exists('artisan')) {
            \Artisan::call('view:clear');
        }

        return redirect()->route('setting.index')
            ->with('success', 'Pengaturan toko berhasil diperbarui.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
