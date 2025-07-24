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
            'store_icon' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update store name
        Setting::set('store_name', $request->store_name);
        
        // Update app name in config (for current request only)
        config(['app.name' => $request->store_name]);

        // Update store icon if provided
        if ($request->hasFile('store_icon')) {
            // Delete old icon if exists
            $oldIcon = Setting::get('store_icon');
            if ($oldIcon && Storage::exists('public/' . $oldIcon)) {
                Storage::delete('public/' . $oldIcon);
            }

            // Store new icon to public disk
            $iconPath = $request->file('store_icon')->store('store', 'public');
            Setting::set('store_icon', $iconPath);
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
