<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Payment;
use App\Models\Withdrawal_request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    public function withdrawalRequests(){
        $title = trans('app.withdrawal_requests');
        $withdraw_requests = Withdrawal_request::orderBy('id', 'desc')->paginate(20);

        return view('admin.payments.withdraw_requests', compact('title', 'withdraw_requests'));
    }
}
