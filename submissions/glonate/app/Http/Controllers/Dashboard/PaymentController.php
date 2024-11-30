<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Payment;
use App\Models\Withdrawal_request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    
    public function index(Request $request){
        $user = Auth::user();
        $title = trans('app.payments');

        if ($user->is_admin()){
            if ($request->q){
                $payments = Payment::success()->where('email', 'like', "%{$request->q}%")->orderBy('id', 'desc')->paginate(20);
            }else{
                $payments = Payment::success()->orderBy('id', 'desc')->paginate(20);
            }
        }else{
            $campaign_ids = $user->my_campaigns()->pluck('id')->toArray();
            if ($request->q){
                $payments = Payment::success()->whereIn('campaign_id', $campaign_ids)->where('email', 'like', "%{$request->q}%")->orderBy('id', 'desc')->paginate(20);
            }else{
                $payments = Payment::success()->whereIn('campaign_id', $campaign_ids)->orderBy('id', 'desc')->paginate(20);
            }
        }

        return view('dashboard.payments.index', compact('title', 'payments'));
    }
    
    public function view($id){
        $title = trans('app.payment_details');
        $payment = Payment::find($id);
        return view('dashboard.payments.view', compact('title', 'payment'));
    }

    public function withdraw(){
        $user = Auth::user();
        $title = trans('app.withdraw');
        $campaigns = $user->my_campaigns;
        $withdrawal_requests = Withdrawal_request::whereUserId($user->id)->orderBy('id', 'desc')->get();
        
        return view('dashboard.withdraws.index', compact('title', 'campaigns', 'withdrawal_requests'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function withdrawRequest(Request $request){
        $user_id = Auth::user()->id;
        $campaign_id = $request->withdrawal_campaign_id;

        $requested_withdrawal = Withdrawal_request::whereCampaignId($campaign_id)->first();
        if ($requested_withdrawal){
            return redirect()->back()->with('error', trans('app.this_withdraw_is_processing'));
        }

        $campaign = Campaign::find($campaign_id);
        $withdraw_amount = $campaign->amount_raised()->campaign_owner_commission;
        $total_amount = $campaign->amount_raised()->amount_raised;
        $platform_owner_commission = $campaign->amount_raised()->platform_owner_commission;
        $withdrawal_preference = withdrawal_preference();

        $data = [
            'user_id'                       => $user_id,
            'campaign_id'                   => $campaign_id,
            'total_amount'                  => $total_amount,
            'platform_owner_commission'     => $platform_owner_commission,
            'withdrawal_amount'             => $withdraw_amount,
            'withdrawal_account'            => $withdrawal_preference,
            'status'                        => 'pending',
        ];

        if ($withdrawal_preference == 'paypal'){
            $data['paypal_email']               = withdrawal_preference('paypal_email');
        }elseif ($withdrawal_preference == 'bank'){

            $data['bank_account_holders_name']  = withdrawal_preference('bank_account_holders_name');
            $data['bank_account_number']        = withdrawal_preference('bank_account_number');
            $data['swift_code']                 = withdrawal_preference('swift_code');
            $data['bank_name_full']             = withdrawal_preference('bank_name_full');
            $data['bank_branch_name']           = withdrawal_preference('bank_branch_name');
            $data['bank_branch_city']           = withdrawal_preference('bank_branch_city');
            $data['bank_branch_address']        = withdrawal_preference('bank_branch_address');
            $data['country_id']                 = withdrawal_preference('country_id');
        }

        Withdrawal_request::create($data);

        return redirect()->back()->with('success', trans('app.withdraw_request_sent'));
    }

    public function withdrawRequestView($id){
        $title = trans('app.withdrawal_details');
        $withdraw_request = Withdrawal_request::find($id);
        $user = Auth::user();

        if (! $user->is_admin() ){
            if ($user->id != $withdraw_request->user_id){
                die('Unauthorize request');
            }
        }

        return view('dashboard.withdraws.view', compact('title', 'withdraw_request'));
    }

    public function withdrawalRequestsStatusSwitch(Request  $request, $id = 0){
        $user = Auth::user();
        if (! $user->is_admin()){
            return redirect()->back()->with('error', trans('app.unauthorised_access'));
        }

        $withdraw_request = Withdrawal_request::find($id);
        $withdraw_request->status = $request->type;
        $withdraw_request->save();
        return redirect()->back()->with('success', trans('app.withdrawal_request_status_changed'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @date April 29, 2017
     * @since v.1.1
     */

    public function paymentsPending(Request $request){
        $user = Auth::user();
        $title = trans('app.payments');

        if ($user->is_admin()){
            if ($request->q){
                $payments = Payment::pending()->where('email', 'like', "%{$request->q}%")->orderBy('id', 'desc')->paginate(20);
            }else{
                $payments = Payment::pending()->orderBy('id', 'desc')->paginate(20);
            }
        }else{
            $campaign_ids = $user->my_campaigns()->pluck('id')->toArray();
            if ($request->q){
                $payments = Payment::pending()->whereIn('campaign_id', $campaign_ids)->where('email', 'like', "%{$request->q}%")->orderBy('id', 'desc')->paginate(20);
            }else{
                $payments = Payment::pending()->whereIn('campaign_id', $campaign_ids)->orderBy('id', 'desc')->paginate(20);
            }
        }

        return view('dashboard.payments.index', compact('title', 'payments'));
    }

    public function markSuccess($id, $status){
        $payment = Payment::find($id);
        $payment->status = $status;
        $payment->save();

        return back()->with('success', trans('app.payment_status_changed'));
    }

    public function delete($id){
        Payment::find($id)->delete();
        return back()->with('success', __('app.success'));
    }

}
