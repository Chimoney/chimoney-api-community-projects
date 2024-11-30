<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\User;
use App\Models\Withdrawal_preference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function index(){
        $title = trans('app.profile');
        $user = Auth::user();
        return view('dashboard.profile.index', compact('title', 'user'));
    }

    public function edit($id = null){
        $title = trans('app.profile_edit');
        $user = Auth::user();

        if ($id){
            $user = User::find($id);
        }

        $countries = Country::orderBy('name', 'asc')->get();

        return view('dashboard.profile.edit', compact('title', 'user', 'countries'));
    }

    public function update($id = null, Request $request){
        if(config('app.is_demo')){
            return redirect()->back()->with('error', 'This feature has been disable for demo');
        }

        $user = Auth::user();
        if ($id){
            $user = User::find($id);
        }
        //Validating
        $rules = [
            'email'    => 'required|email|unique:users,email,'.$user->id,
        ];
        $this->validate($request, $rules);

        $inputs = array_except($request->input(), ['_token', 'photo']);
        $user->update($inputs);

        if ($request->hasFile('photo')){
            $rules = ['photo'=>'mimes:jpeg,jpg,png'];
            $this->validate($request, $rules);

            $image = $request->file('photo');
            $file_base_name = str_replace('.'.$image->getClientOriginalExtension(), '', $image->getClientOriginalName());


            $resized = Image::make($image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $image_name = strtolower(time().str_random(5).'-'.str_slug($file_base_name)).'.' . $image->getClientOriginalExtension();

            $upload_dir = './storage/uploads/avatar/';
            if ( ! file_exists($upload_dir)){
                mkdir($upload_dir, 0777, true);
            }

            $imageFileName = $upload_dir.$image_name;

            try{
                //Uploading thumb
                $resized->save($imageFileName);

                $previous_photo= $user->photo;
                $user->photo = $image_name;
                $user->save();

                if ($previous_photo){
                    if (file_exists($upload_dir.$previous_photo)){
                        unlink($upload_dir.$previous_photo);
                    }
                }

            } catch (\Exception $e){
                return $e->getMessage();
            }

        }

        return back()->with('success', trans('app.profile_edit_success_msg'));
    }

    public function withdrawalPreference(){
        $title = trans('app.withdrawal_preference');
        $user = Auth::user();

        $countries = Country::orderBy('name', 'asc')->get();
        return view('dashboard.profile.withdrawal_preference', compact('title', 'user', 'countries'));
    }

    public function withdrawalPreferenceUpdate(Request $request){
        $user_id = Auth::user()->id;
        $rules = [
            'default_withdrawal_account'    =>'required'
        ];
        $this->validate($request, $rules);

        $data = [
            'default_withdrawal_account'    => $request->default_withdrawal_account,
            'paypal_email'                  => $request->paypal_email,
            'bank_account_holders_name'     => $request->bank_account_holders_name,
            'bank_account_number'           => $request->bank_account_number,
            'swift_code'                    => $request->swift_code,
            'bank_name_full'                => $request->bank_name_full,
            'bank_branch_name'              => $request->bank_branch_name,
            'bank_branch_city'              => $request->bank_branch_city,
            'bank_branch_address'           => $request->bank_branch_address,
            'country_id'                    => $request->country_id,
            'user_id'                       => $user_id,
        ];

        $withdrawal_preference = Withdrawal_preference::whereUserId($user_id)->first();
        if ($withdrawal_preference){
            $withdrawal_preference->update($data);
        }else{
            Withdrawal_preference::create($data);
        }

        return redirect()->back()->with('success', trans('app.changes_has_been_saved'));

    }
}
