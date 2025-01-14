<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return response()->json($settings);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|in:Ganjil,Genap',
            'status' => 'required|in:Aktif,Tidak Aktif'
        ]);

        $setting = Setting::create($validated);
        return response()->json($setting, 201);
    }

    public function show(Setting $setting)
    {
        return response()->json($setting);
    }

    public function update(Request $request, Setting $setting)
    {
        $validated = $request->validate([
            'tahun_ajaran' => 'sometimes|required|string',
            'semester' => 'sometimes|required|in:Ganjil,Genap',
            'status' => 'sometimes|required|in:Aktif,Tidak Aktif'
        ]);

        $setting->update($validated);
        return response()->json($setting);
    }

    public function destroy(Setting $setting)
    {
        $setting->delete();
        return response()->json(null, 204);
    }

    public function getActiveSetting()
    {
        $activeSetting = Setting::where('status', 'Aktif')->first();
        if (!$activeSetting) {
            return response()->json(['message' => 'Tidak ada setting aktif'], 404);
        }
        return response()->json($activeSetting);
    }
}
