<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\User;
use App\Models\Withdrawal_preference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{

    public function index(){
        $title = trans('app.users');
        $users = User::orderBy('name', 'asc')->paginate(20);
        $users_count = User::count();
        return view('admin.users.index', compact('title', 'users', 'users_count'));
    }

    public function show($id = 0){
        if ($id){
            $title = trans('app.profile');
            $user = User::find($id);

            $is_user_id_view = true;
            return view('admin.users.show', compact('title', 'user', 'is_user_id_view'));
        }
    }

    /**
     * @param $id
     * @param null $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function statusChange($id, $status = null){
        if(config('app.is_demo')){
            return redirect()->back()->with('error', 'This feature has been disable for demo');
        }

        $user = User::find($id);
        if ($user && $status){
            if ($status == 'approve'){
                $user->active_status = 1;
                $user->save();

            }elseif($status == 'block'){
                $user->active_status = 2;
                $user->save();
            }
        }
        return back()->with('success', trans('app.status_updated'));
    }

    public function edit($id = null){
        $title = trans('app.profile_edit');
        $user = Auth::user();

        if ($id){
            $user = User::find($id);
        }

        $countries = Country::orderBy('name', 'asc')->get();

        return view('admin.users.edit', compact('title', 'user', 'countries'));
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

            $upload_dir = './uploads/avatar/';
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

}
