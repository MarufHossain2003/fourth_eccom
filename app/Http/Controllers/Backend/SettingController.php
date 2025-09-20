<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CommonSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function ShowSetting()
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $settings = CommonSetting::first();
                return view('backend.admin.setting', compact('settings'));
            }
        }
    }

    public function updateSetting(Request $request)
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $settings = CommonSetting::first();

                if(isset($request->logo)){
                    if($settings->logo && file_exists('backend/images/settings/'.$settings->logo)){
                        unlink('backend/images/settings/'.$settings->logo);
                    }
                    $imageName = rand().'-logo-'.'.'.$request->logo->extension();
                    $request->logo->move('backend/images/settings/', $imageName);
                    $settings->logo = $imageName;
                }
                if(isset($request->favicon)){
                    if($settings->favicon && file_exists('backend/images/settings/'.$settings->favicon)){
                        unlink('backend/images/settings/'.$settings->favicon);
                    }
                    $imageName = rand().'-favicon-'.'.'.$request->favicon->extension();
                    $request->favicon->move('backend/images/settings/', $imageName);
                    $settings->favicon = $imageName;
                }

                $settings->phone    = $request->phone;
                $settings->email    = $request->email;
                $settings->address  = $request->address;
                $settings->facebook = $request->facebook;
                $settings->twitter  = $request->twitter;
                $settings->linkedin = $request->linkedin;
                $settings->instagram = $request->instagram;
                $settings->youtube  = $request->youtube;

                $settings->save();
                toastr()->success('Settings updated successfully!');
                return redirect()->back();
            }
        }
    }
}
