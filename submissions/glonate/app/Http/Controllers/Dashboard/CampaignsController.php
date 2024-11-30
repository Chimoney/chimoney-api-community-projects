<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Country;
use App\Models\Payment;
use App\Models\Reward;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class CampaignsController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('app.start_a_campaign');
        $categories = Category::all();
        $countries = Country::orderBy('name', 'asc')->get();

        return view('dashboard.campaigns.create', compact('title', 'categories', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $rules = [
            'category'      => 'required',
            'title'         => 'required',
            'description'   => 'required',
            'short_description' => 'required|max:200',
            'goal'          => 'required',
            'end_method'    => 'required',
            'country_id'    => 'required',
        ];

        $this->validate($request, $rules);

        $user_id = Auth::user()->id;

        $slug = unique_slug($request->title);

        //feature image has been moved to update
        $data = [
            'user_id'           => $user_id,
            'category_id'       => $request->category,
            'title'             => $request->title,
            'slug'              => $slug,
            'short_description' => $request->short_description,
            'description'       => $request->description,
            'campaign_owner_commission'              => get_option('campaign_owner_commission'),
            'goal'              => $request->goal,
            'min_amount'        => $request->min_amount,
            'max_amount'        => $request->max_amount,
            'recommended_amount' => $request->recommended_amount,
            'amount_prefilled'  => $request->amount_prefilled,
            'end_method'        => $request->end_method,
            'video'             => $request->video,
            'feature_image'     => '',
            'status'            => 0,
            'country_id'        => $request->country_id,
            'address'           => $request->address,
            'is_funded'         => 0,
            'start_date'        => $request->start_date,
            'end_date'          => $request->end_date,
        ];

        $create = Campaign::create($data);

        if ($create){
            return redirect(route('edit_campaign', $create->id))->with('success', trans('app.campaign_created'));
        }
        return back()->with('error', trans('app.something_went_wrong'))->withInput($request->input());
    }


    public function myCampaigns(){
        $title = trans('app.my_campaigns');
        $user = request()->user();
        //$my_campaigns = $user->my_campaigns;
        $my_campaigns = Campaign::whereUserId($user->id)->orderBy('id', 'desc')->get();

        return view('dashboard.campaigns.index', compact('title', 'my_campaigns'));
    }

    public function myPendingCampaigns(){
        $title = trans('app.pending_campaigns');
        $user = request()->user();
        $my_campaigns = Campaign::pending()->whereUserId($user->id)->orderBy('id', 'desc')->get();

        return view('dashboard.campaigns.index', compact('title', 'my_campaigns'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = request()->user();
        $campaign = Campaign::findOrFail($id);

        if ($campaign->user_id != $user->id && !$user->is_admin()){
            exit('Unauthorized access');
        }

        $title = trans('app.edit_campaign');
        $categories = Category::all();
        $countries = Country::orderBy('name', 'asc')->get();

        return view('dashboard.campaigns.edit', compact('title', 'categories', 'countries', 'campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

        $rules = [
            'category'      => 'required',
            'title'         => 'required',
            'short_description' => 'required|max:200',
            'description'   => 'required',
            'goal'          => 'required',
            'country_id'    => 'required',
        ];

        $this->validate($request, $rules);

        $campaign = Campaign::findOrFail($id);

        $image_name = $campaign->feature_image;
        if ($request->hasFile('feature_image')){

            $image = $request->file('feature_image');

            $valid_extensions = ['jpg','jpeg','png'];
            if ( ! in_array(strtolower($image->getClientOriginalExtension()), $valid_extensions) ){
                return redirect()->back()->withInput($request->input())->with('error', 'Only .jpg, .jpeg and .png is allowed extension') ;
            }

            $upload_dir = './storage/uploads/campaigns/large/';
            if ( ! file_exists($upload_dir)){
                mkdir($upload_dir, 0777, true);
            }
            $thumb_dir = './storage/uploads/campaigns/thumb/';
            if ( ! file_exists($thumb_dir)){
                mkdir($thumb_dir, 0777, true);
            }

            //Delete old image
            if ($image_name){
                if (file_exists($upload_dir.$image_name)){
                    unlink($upload_dir.$image_name);
                }
                if (file_exists($thumb_dir.$image_name)){
                    unlink($thumb_dir.$image_name);
                }
            }

            $file_base_name = str_replace('.'.$image->getClientOriginalExtension(), '', $image->getClientOriginalName());
            $full_image = Image::make($image)->orientate()->resize(1500, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $resized = Image::make($image)->orientate()->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $image_name = strtolower(time().str_random(5).'-'.str_slug($file_base_name)).'.' . $image->getClientOriginalExtension();

            $thumbFileName = $thumb_dir.$image_name;
            $imageFileName = $upload_dir.$image_name;

            try{
                //Uploading original image
                $full_image->save($imageFileName);
                //Uploading thumb
                $resized->save($thumbFileName);
            } catch (\Exception $e){
                return $e->getMessage();
            }
        }

        $data = [
            'category_id'       => $request->category,
            'title'             => $request->title,
            'short_description' => $request->short_description,
            'description'       => $request->description,
            'goal'              => $request->goal,
            'min_amount'        => $request->min_amount,
            'max_amount'        => $request->max_amount,
            'recommended_amount' => $request->recommended_amount,
            'amount_prefilled'  => $request->amount_prefilled,
            'end_method'        => $request->end_method,
            'video'             => $request->video,
            'feature_image'     => $image_name,
            'country_id'        => $request->country_id,
            'address'           => $request->address,
            'start_date'        => $request->start_date,
            'end_date'          => $request->end_date,
        ];

        $update = Campaign::whereId($id)->update($data);

        if ($update){
            return redirect(route('edit_campaign', $id))->with('success', trans('app.campaign_created'));
        }
        return back()->with('error', trans('app.something_went_wrong'))->withInput($request->input());
    }
}
