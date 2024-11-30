<?php

namespace App\Http\Controllers\Public;

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $slug = null)
    {
        $campaign = Campaign::findOrFail($id);
        $title = $campaign->title;

        $enable_discuss = get_option('enable_disqus_comment');
        return view('public.campaigns.show', compact('campaign', 'title', 'enable_discuss'));
    }

    /**
     * @return mixed
     */
    public function newCampaignsAjax(){
        $new_campaigns = Campaign::whereStatus(1)->orderBy('id', 'desc')->paginate(8);
        $new_campaigns->withPath('ajax/new-campaigns');

        if ($new_campaigns->count()){
            return view('public.campaigns.partials.campaigns_ajax', compact('new_campaigns'));
        }
        return ['success' => false];
    }

    public function showBackers($id){
        $campaign = Campaign::findOrFail($id);
        $title = trans('app.backers').' | '.$campaign->title;
        return view('public.campaigns.backers', compact('campaign', 'title'));

    }

    public function showUpdates($id){
        $campaign = Campaign::findOrFail($id);
        $title = $campaign->title;
        return view('public.campaigns.update', compact('campaign', 'title'));
    }

    public function showFaqs($id){
        $campaign = Campaign::findOrFail($id);
        $title = $campaign->title;
        return view('public.campaigns.faqs', compact('campaign', 'title'));
    }
}
