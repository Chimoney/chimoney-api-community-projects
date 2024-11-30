<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller
{

    public function GeneralSettings(){
        $title = trans('app.general_settings');
        return view('admin.settings.general', compact('title'));
    }

    public function PaymentSettings(){
        $title = trans('app.payment_settings');
        return view('admin.settings.payment', compact('title'));
    }
    
    public function SocialSettings(){
        $title = trans('app.social_settings');
        return view('admin.settings.social', compact('title'));
    }

    public function reCaptchaSettings(){
        $title = trans('app.re_captcha_settings');
        return view('admin.settings.re_captcha', compact('title'));
    }

    public function OtherSettings(){
        $title = trans('app.other_settings');
        return view('admin.settings.other', compact('title'));
    }
    public function ThemeSettings(){
        $title = trans('app.theme_settings');
        return view('admin.settings.theme', compact('title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request) {
        $inputs = array_except($request->input(), ['_token']);

        foreach($inputs as $key => $value) {
            $option = Option::firstOrCreate(['option_key' => $key]);
            $option -> option_value = $value;
            $option->save();
        }

        if ($request->ajax()){
            return ['success'=>1, 'msg'=>trans('app.settings_saved_msg')];
        }
        return redirect()->back()->with('success', trans('app.settings_saved_msg'));
    }

    public function OtherSettingsPost(Request $request){

        if ($request->hasFile('logo')){
            $rules = ['logo'=>'mimes:jpeg,jpg,png'];
            $this->validate($request, $rules);

            $image = $request->file('logo');
            $file_base_name = str_replace('.'.$image->getClientOriginalExtension(), '', $image->getClientOriginalName());

            $image_name = strtolower(time().str_random(5).'-'.str_slug($file_base_name)).'.' . $image->getClientOriginalExtension();

            $upload_dir = './uploads/logo/';
            if ( ! file_exists($upload_dir)){
                mkdir($upload_dir, 0777, true);
            }
            $imageFileName = $upload_dir.$image_name;


            $resized = Image::make($image)->resize(null, 70, function ($constraint) {
                $constraint->aspectRatio();
            });

            try{
                //Uploading thumb
                $resized->save($imageFileName);
                $previous_photo= get_option('logo');
                update_option('logo', $image_name );

                if ($previous_photo){
                    if (file_exists($upload_dir.$previous_photo)){
                        unlink($upload_dir.$previous_photo);
                    }
                }

            } catch (\Exception $e){
                return $e->getMessage();
            }

        }

        return back();

    }




    /*public function modernThemeSettings(){
        $title = trans('app.modern_theme_settings');
        return view('admin.settings.modern_theme', compact('title'));
    }

    public function SocialUrlSettings(){
        $title = trans('app.social_url_settings');
        return view('admin.settings.social_url', compact('title'));
    }*/
    /*public function BlogSettings(){
        $title = trans('app.blog_settings');
        return view('admin.settings.blog', compact('title'));
    }*/

    /*public function AdSettings(){
        $title = trans('app.ad_settings_and_pricing');
        return view('admin.settings.ad', compact('title'));
    }

    public function StorageSettings(){
        $title = trans('app.file_storage_settings');
        return view('admin.settings.storage', compact('title'));
    }*/
    /*public function monetization(){
        $title = trans('app.website_monetization');
        return view('admin.settings.website_monetization', compact('title'));
    }*/

}
