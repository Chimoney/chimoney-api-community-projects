<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $title = trans('app.campaign_faqs');
        $campaign_id = $id;
        $faqs = Faq::whereCampaignId($id)->get();
        return view('dashboard.faqs.index', compact('title', 'faqs', 'campaign_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $rules = [
            'title'                => 'required',
            'description'              => 'required',
        ];
        $this->validate($request, $rules);

        $user_id = request()->user()->id;

        $data = array_merge(array_except($request->input(), '_token'), [
            'user_id'       => $user_id,
            'campaign_id'   => $id,
        ]);

        $create = Faq::create($data );

        if ($create){
            return back()->with('success', trans('app.faq_created'));
        }
        return back()->with('error', trans('app.something_went_wrong'))->withInput($request->input());

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit($campaign_id, $faq_id)
    {
        $user_id = request()->user()->id;
        $title = trans('app.edit_faq');
        $faq = Faq::find($faq_id);
        if ($campaign_id != $faq->campaign_id || $user_id != $faq->user_id){
            die(trans('app.unauthorised_access'));
        }
        return view('dashboard.faqs.edit', compact('title', 'faq'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $campaign_id, $udpate_id)
    {
        $rules = [
            'title'                => 'required',
            'description'              => 'required',
        ];
        $this->validate($request, $rules);

        $data = array_merge(array_except($request->input(), '_token'));
        $update = Faq::whereId($udpate_id)->update($data );

        if ($update){
            return redirect(route('edit_campaign_faqs', $campaign_id))->with('success', trans('app.faq_updated'));
        }
        return back()->with('error', trans('app.something_went_wrong'))->withInput($request->input());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq, Request $request)
    {
        $user_id = request()->user()->id;
        $data_id = $request->data_id;
        $r = $faq::find($data_id);
        if ($r->user_id != $user_id){
            die(trans('app.unauthorised_access'));
        }
        $r->delete();
        return ['success' => 1];
    }
}
