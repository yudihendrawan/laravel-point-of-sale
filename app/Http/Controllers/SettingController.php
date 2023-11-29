<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index()
    {
        return view('setting.index');
    }

    public function show()
    {
        return Setting::first();
    }

    public function update(Request $request)
    {
        $setting = Setting::first();
        $setting->nama_perusahaan = $request->nama_perusahaan;
        $setting->telepon = $request->telepon;
        $setting->alamat = $request->alamat;
        $setting->diskon = $request->diskon;
        $setting->tipe_nota = $request->tipe_nota;

        if ($request->hasFile('path_logo')) {
            $file = $request->file('path_logo');
            $nama = 'logo-' . date('YmdHis') . '.' . $file->getClientOriginalExtension();

            // Hapus foto lama jika ada
            if (File::exists(public_path($setting->path_logo))) {
                File::delete(public_path($setting->path_logo));
            }

            $file->move(public_path('/img'), $nama);
            $setting->path_logo = "/img/$nama";
        }

        if ($request->hasFile('path_kartu_member')) {
            $file = $request->file('path_kartu_member');
            $nama = 'logo-' . date('Y-m-dHis') . '.' . $file->getClientOriginalExtension();

            // Hapus foto lama jika ada
            if (File::exists(public_path($setting->path_kartu_member))) {
                File::delete(public_path($setting->path_kartu_member));
            }

            $file->move(public_path('/img/logo'), $nama);
            $setting->path_kartu_member = "/img/logo/$nama";
        }

        $setting->update();

        return response()->json('Data berhasil disimpan', 200);
    }
}
