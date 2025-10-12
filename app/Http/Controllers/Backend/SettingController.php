<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CommonSetting;
use App\Models\HomeBanner;
use App\Models\PaymentPolicy;
use App\Models\PrivacyPolicy;
use App\Models\RefundPolicy;
use App\Models\TermsConditions;
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

    public function showHomeBanner()
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $homeBanner = HomeBanner::first();
                return view('backend.admin.home-banner', compact('homeBanner'));
            }
        }
    }

    public function updateHomeBanner(Request $request)
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                if(isset($request->banner)){
                    $homeBanner = HomeBanner::first();
                    if($homeBanner->banner && file_exists('backend/images/settings/'.$homeBanner->banner)){
                        unlink('backend/images/settings/'.$homeBanner->banner);
                    }
                    $imageName = rand().'-banner-'.'.'.$request->banner->extension();
                    $request->banner->move('backend/images/settings/', $imageName);
                    $homeBanner->banner = $imageName;
                }
                $homeBanner->save();
                toastr()->success('Home Banner updated successfully!');
                return redirect()->back();
            }
        }
    }

    public function showPrivacyPolicy()
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $privacyPolicy = PrivacyPolicy::first();
                return view('backend.admin.settings.privacy-policy', compact('privacyPolicy'));
            }
        }
    }

    public function updatePrivacyPolicy(Request $request)
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $privacyPolicy = PrivacyPolicy::first();
                $privacyPolicy->description = $request->privacyPolicy;
                $privacyPolicy->save();
                toastr()->success('Privacy Policy updated successfully!');
                return redirect()->back();
            }
        }
    }

    // Authentication 
    public function adminLogout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function adminCredentials()
    {
        if(Auth::user()){
            if(Auth::user()->role == 1 || Auth::user()->role == 2){
                $authUser = Auth::user();
                return view ('backend.admin.credentials', compact('authUser'));
            }
        }
    }

    public function adminCredentialsUpdate(Request $request)
    {
        if(Auth::user()){
            if(Auth::user()->role == 1 || Auth::user()->role == 2){
                $authUser = Auth::user();
                if(password_verify($request->old_password, $authUser->password)){
                    $authUser->password = $request->password;
                    $authUser->save();
                    Auth::logout();
                    toastr()->success('Credentials updated successfully!');
                    return redirect('/login');
                } 
                else {
                    toastr()->error('Old password does not match!');
                    return redirect()->back();
                }
                
            }
        }
    }

    public function showTermsConditions()
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $termsConditions = TermsConditions::first();
                return view ('backend.admin.settings.terms-conditions', compact('termsConditions'));
            }
        }
    }

    public function updateTermsConditions(Request $request)
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $termsConditions = TermsConditions::first();
                $termsConditions->description = $request->termsConditions;
                $termsConditions->save();
                toastr()->success('Terms and Conditions updated successfully!');
                return redirect()->back();
            }
        }
    }

    public function showRefundPolicy()
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $refundPolicy = RefundPolicy::first();
                return view ('backend.admin.settings.refund-policy', compact('refundPolicy'));
            }
        }
    }

    public function updateRefundPolicy(Request $request)
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $refundPolicy = RefundPolicy::first();
                $refundPolicy->description = $request->refundPolicy;
                $refundPolicy->save();
                toastr()->success('Refund Policy updated successfully!');
                return redirect()->back();
            }
        }
    }

    public function showPaymentPolicy()
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $paymentPolicy = PaymentPolicy::first();
                return view ('backend.admin.settings.payment-policy', compact('paymentPolicy'));
            }
        }
    }

    public function updatePaymentPolicy(Request $request)
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $paymentPolicy = PaymentPolicy::first();
                $paymentPolicy->description = $request->paymentPolicy;
                $paymentPolicy->save();
                toastr()->success('Payment Policy updated successfully!');
                return redirect()->back();
            }
        }
    }
}
