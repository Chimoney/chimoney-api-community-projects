<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Update;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $title = trans('app.campaign_updates');
        $campaign_id = $id;
        $updates = Update::whereCampaignId($id)->get();
        return view('dashboard.updates.index', compact('title', 'updates', 'campaign_id'));
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

        $create = Update::create($data );

        if ($create){
            return back()->with('success', trans('app.update_created'));
        }
        return back()->with('error', trans('app.something_went_wrong'))->withInput($request->input());

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Update  $update
     * @return \Illuminate\Http\Response
     */
    public function show(Update $update)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Update  $update
     * @return \Illuminate\Http\Response
     */
    public function edit($campaign_id, $udpate_id)
    {
        $user_id = request()->user()->id;
        $title = trans('app.edit_reward');
        $update = Update::find($udpate_id);
        $campaign = Campaign::findOrFail($campaign_id);
        if ($campaign_id != $update->campaign_id || $user_id != $update->user_id){
            die(trans('app.unauthorised_access'));
        }
        return view('dashboard.updates.edit', compact('title', 'campaign', 'update'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Update  $update
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

        $update = Update::whereId($udpate_id)->update($data );

        if ($update){
            return redirect(route('edit_campaign_updates', $campaign_id))->with('success', trans('app.update_updated'));
        }
        return back()->with('error', trans('app.something_went_wrong'))->withInput($request->input());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Update  $update
     * @return \Illuminate\Http\Response
     */
    public function destroy(Update $update, Request $request)
    {
        $user_id = request()->user()->id;
        $data_id = $request->data_id;
        $r = $update::find($data_id);
        if ($r->user_id != $user_id){
            die(trans('app.unauthorised_access'));
        }
        $r->delete();
        return ['success' => 1];
    }
}
