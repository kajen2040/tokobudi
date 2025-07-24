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
        try {
            $request->validate([
                'store_name' => 'required|string|max:255',
                'store_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        // Update store name
        Setting::set('store_name', $request->store_name);
        
        // Update app name in config (for current request only)
        config(['app.name' => $request->store_name]);

        // Update store icon if provided
        if ($request->hasFile('store_icon')) {
            try {
                // Laravel Cloud optimization: Process image early
                $file = $request->file('store_icon');
                
                // Additional validation for Laravel Cloud
                if (!$file->isValid()) {
                    throw new \Exception('File upload tidak valid');
                }
                
                // Check actual file size (Laravel Cloud optimization)
                if ($file->getSize() > 1048576) { // 1MB in bytes
                    throw new \Exception('Ukuran file terlalu besar. Maksimal 1MB');
                }

                // Delete old icon if exists
                $oldIcon = Setting::get('store_icon');
                if ($oldIcon && Storage::exists('public/' . $oldIcon)) {
                    Storage::delete('public/' . $oldIcon);
                }

                // Store new icon to public disk with Laravel Cloud optimization
                $iconPath = $file->store('store', 'public');
                Setting::set('store_icon', $iconPath);
                
                // Clear any relevant caches for Laravel Cloud
                if (function_exists('opcache_reset')) {
                    opcache_reset();
                }
                
            } catch (\Exception $e) {
                \Log::error('Icon upload failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Gagal mengupload ikon: ' . $e->getMessage());
            }
        }

        // Clear the view cache to ensure new settings are applied
        try {
            if (function_exists('artisan')) {
                \Artisan::call('view:clear');
            }
        } catch (\Exception $e) {
            \Log::warning('Failed to clear view cache: ' . $e->getMessage());
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
