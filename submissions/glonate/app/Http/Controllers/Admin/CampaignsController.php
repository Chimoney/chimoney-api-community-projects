<?php

namespace App\Http\Controllers\Admin;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    
    public function allCampaigns(){
        $title = trans('app.all_campaigns');
        $campaigns = Campaign::active()->orderBy('id', 'desc')->paginate(20);
        return view('admin.campaigns.index', compact('title', 'campaigns'));
    }
    
    public function fundedCampaigns(){
        $title = trans('app.funded');
        $campaigns = Campaign::funded()->orderBy('id', 'desc')->paginate(20);
        return view('admin.campaigns.index', compact('title', 'campaigns'));
    }


    public function blockedCampaigns(){
        $title = trans('app.blocked_campaigns');
        $campaigns = Campaign::blocked()->orderBy('id', 'desc')->paginate(20);
        return view('admin.campaigns.index', compact('title', 'campaigns'));
    }
    public function pendingCampaigns(){
        $title = trans('app.pending_campaigns');
        $campaigns = Campaign::pending()->orderBy('id', 'desc')->paginate(20);
        return view('admin.campaigns.index', compact('title', 'campaigns'));
    }

    public function expiredCampaigns(){
        $title = trans('app.expired_campaigns');
        $campaigns = Campaign::active()->expired()->orderBy('id', 'desc')->paginate(20);
        return view('admin.campaigns.index', compact('title', 'campaigns'));
    }


    public function searchAdminCampaigns(Request $request){
        $title = trans('app.campaigns_search_results');
        $campaigns = Campaign::where('title', 'like', "%{$request->q}%")->orderBy('id', 'desc')->paginate(20);
        return view('admin.campaigns.index', compact('title', 'campaigns'));
    }

    public function deleteCampaigns($id = 0){
        if(config('app.is_demo')){
            return redirect()->back()->with('error', 'This feature has been disable for demo');
        }

        if ($id){
            $campaign = Campaign::findOrFail($id);
            if ($campaign){
                $campaign->delete();
            }
        }
        return back()->with('success', trans('app.campaign_deleted'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function statusChange($id, $status = null){

        $campaign = Campaign::findOrFail($id);
        if ($campaign && $status){

            if ($status == 'approve'){
                $campaign->status = 1;
                $campaign->save();

            }elseif($status == 'block'){
                $campaign->status = 2;
                $campaign->save();
            }elseif($status == 'funded'){
                $campaign->is_funded = 1;
                $campaign->save();
            }elseif ($status == 'add_staff_picks'){
                $campaign->is_staff_picks = 1;
                $campaign->save();

            }elseif($status == 'remove_staff_picks'){
                $campaign->is_staff_picks = 0;
                $campaign->save();
            }

        }
        return back()->with('success', trans('app.status_updated'));
    }
}
