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
use Unicodeveloper\Paystack\Facades\Paystack;



class CheckoutController extends Controller
{
    /**
     * @param Request $request
     * @param int $reward_id
     * @return mixed
     */
    public function addToCart(Request $request, $reward_id = 0)
    {
        if ($reward_id) {
            //If checkout request come from reward
            session(['cart' =>  ['cart_type' => 'reward', 'reward_id' => $reward_id] ]);

            $reward = Reward::find($reward_id);
            if($reward->campaign->is_ended()) {
                $request->session()->forget('cart');
                return redirect()->back()->with('error', trans('app.invalid_request'));
            }
        } else {
            //Or if comes from donate button
            session(['cart' =>  ['cart_type' => 'donation', 'campaign_id' => $request->campaign_id, 'amount' => $request->amount ] ]);
        }


        return redirect(route('checkout'));
    }

    /**
     * @return mixed
     *
     * Checkout page
     */
    public function checkout()
    {
        $title = trans('app.checkout');

        if (! session('cart')) {
            return view('public.checkout.empty', compact('title'));
        }

        $reward = null;
        if(session('cart.cart_type') == 'reward') {
            $reward = Reward::find(session('cart.reward_id'));
            $campaign = Campaign::find($reward->campaign_id);
        } elseif (session('cart.cart_type') == 'donation') {
            $campaign = Campaign::find(session('cart.campaign_id'));
        }
        if (session('cart')) {
            return view('public.checkout.index', compact('title', 'campaign', 'reward'));
        }
        return view('public.checkout.empty', compact('title'));
    }

    public function checkoutPost(Request $request)
    {
        $title = trans('app.checkout');

        if (! session('cart')) {
            return view('public.checkout.empty', compact('title'));
        }

        $cart = session('cart');
        $input = array_except($request->input(), '_token');
        session(['cart' => array_merge($cart, $input)]);

        if(session('cart.cart_type') == 'reward') {
            $reward = Reward::find(session('cart.reward_id'));
            $campaign = Campaign::find($reward->campaign_id);
        } elseif (session('cart.cart_type') == 'donation') {
            $campaign = Campaign::find(session('cart.campaign_id'));
        }

        //dd(session('cart'));
        return view('public.checkout.payment', compact('title', 'campaign'));
    }


    /**
     * @return mixed
     *
     * receive card payment from paystack
     */
    public function payWithPaystack(Request $request)
    {
    // Retrieve the payment details from the session
    $cart = session('cart');
    $amount = $cart['amount'];


    if ('cart.cart_type' === 'reward') {
        $reward = Reward::find($cart['reward_id']);
        $amount = $reward->amount;
        $campaign = Campaign::find($reward->campaign_id);
    } elseif ('cart.cart_type' === 'donation') {
        $campaign = Campaign::find($cart['campaign_id']);
        $amount = $cart['amount'];
    }
    $currency = get_option('currency_sign');
    $user_id = null;
    if (Auth::check()) {
        $user_id = Auth::user()->id;
    }
    $transaction_id = 'tran_' . time() . str_random(6);
    // get unique recharge transaction id
    while((Payment::whereLocalTransactionId($transaction_id)->count()) > 0) {
        $transaction_id = 'reid' . time() . str_random(5);
    }
    $transaction_id = strtoupper($transaction_id);

    $payments_data = [
        'name' => session('cart.full_name'),
        'email' => session('cart.email'),

        'user_id'               => $user_id,
        'campaign_id'           => session('cart.campaign_id'),
        'reward_id'             => session('cart.reward_id'),

        'amount'                => $amount,
        'payment_method'        => 'paystack',
        'status'                => 'initial',
        'currency'              => $currency,
        'local_transaction_id'  => $transaction_id,

        'contributor_name_display'  => session('cart.contributor_name_display'),
    ];

    //Create payment and clear it from session
    $created_payment = Payment::create($payments_data);
    $request->session()->forget('cart');

    // Define the payment data for Paystack
    $data = [
        'amount' => $amount * 100, // Paystack uses kobo (1 Naira = 100 kobo)
        'email' => $payments_data['email'],
        'currency' => 'NGN', // Nigerian Naira (change as needed)
        'metadata' => [
            'transaction_id' => $payments_data['local_transaction_id'],
            'contributor_name_display' => $payments_data['contributor_name_display'],
        ],
    ];


    // Create a Paystack payment link
    return Paystack::getAuthorizationUrl($data)->redirectNow();

    // Redirect the user to the Paystack paymen
}
public function payWithChimoney(Request $request)
{
    $cart = session('cart');
    $amount = $cart['amount'];
    $valueInUSD = $amount;  // Set valueInUSD to the cart's amount

    if ($cart['cart_type'] === 'reward') {
        $reward = Reward::find($cart['reward_id']);
        $amount = $reward->amount;
        $campaign = Campaign::find($reward->campaign_id);
    } elseif ($cart['cart_type'] === 'donation') {
        $campaign = Campaign::find($cart['campaign_id']);
        $amount = $cart['amount'];
    }

    // Retrieve payer email from the cart data
    $payerEmail = $cart['email'];

    $currency = get_option('currency_sign');
    $user_id = null;
    if (Auth::check()) {
        $user_id = Auth::user()->id;
    }

    $transaction_id = 'tran_' . time() . str_random(6);
    while ((Payment::whereLocalTransactionId($transaction_id)->count()) > 0) {
        $transaction_id = 'reid' . time() . str_random(5);
    }
    $transaction_id = strtoupper($transaction_id);

    $payments_data = [
        'name' => session('cart.full_name'),
        'email' => $payerEmail,  // Use the retrieved payer email
        'user_id' => $user_id,
        'campaign_id' => session('cart.campaign_id'),
        'reward_id' => session('cart.reward_id'),
        'amount' => $amount,
        'payment_method' => 'chimoney',
        'status' => 'initial',
        'currency' => $currency,
        'local_transaction_id' => $transaction_id,
        'contributor_name_display' => session('cart.contributor_name_display'),
    ];

    $created_payment = Payment::create($payments_data);
    $request->session()->forget('cart');

    // Construct the JSON payload for the API request
    $apiPayload = json_encode([
        'valueInUSD' => $valueInUSD,
        'payerEmail' => $payerEmail,
        'redirect_url' => route('payment_success', ['transaction_id' => $transaction_id]),  // Use the route
    ]);

    // Make the POST request to the Chimoney API
    $client = new \GuzzleHttp\Client();
    $response = $client->request('POST', 'https://api-v2-sandbox.chimoney.io/v0.2/payment/initiate', [
        'body' => $apiPayload,  // Send the JSON payload
        'headers' => [
            'X-API-KEY' => env('CHIMONEY_API_KEY'),
            'Content-Type' => 'application/json',
        ],
    ]);

    $apiResponse = json_decode((string) $response->getBody(), true);

    if (isset($apiResponse['data']['paymentLink'])) {
        // Redirect to the paymentLink
        return redirect($apiResponse['data']['paymentLink']);
    } else {
        // Handle the case where paymentLink is not present in the response
        return response()->json(['error' => 'Payment link not found in the API response']);
    }
}


    
    public function payment_success_html()
    {
        $html = ' <div class="payment-received">
                            <h1> <i class="fa fa-check-circle-o"></i> ' . trans('app.payment_thank_you') . '</h1>
                            <p>' . trans('app.payment_receive_successfully') . '</p>
                            <a href="' . route('home') . '" class="btn btn-filled">' . trans('app.home') . '</a>
                        </div>';
        return $html;
    }

    public function paymentSuccess(Request $request, $transaction_id = null)
    {
        if ($transaction_id) {
            $payment = Payment::whereLocalTransactionId($transaction_id)->whereStatus('initial')->first();
            if ($payment) {
                $payment->status = 'success';
                $payment->save();
            }
        }

        $title = trans('app.payment_success');
        return view('public.checkout.success', compact('title'));
    }

    public function paymentBankTransferReceive(Request $request)
    {
        $rules = [
            'bank_swift_code'   => 'required',
            'account_number'    => 'required',
            'branch_name'       => 'required',
            'branch_address'    => 'required',
            'account_name'      => 'required',
        ];
        $this->validate($request, $rules);

        //get Cart Item
        if (! session('cart')) {
            $title = trans('app.checkout');
            return view('public.checkout.empty', compact('title'));
        }
        //Find the campaign
        $cart = session('cart');

        $amount = 0;
        if(session('cart.cart_type') == 'reward') {
            $reward = Reward::find(session('cart.reward_id'));
            $amount = $reward->amount;
            $campaign = Campaign::find($reward->campaign_id);
        } elseif (session('cart.cart_type') == 'donation') {
            $campaign = Campaign::find(session('cart.campaign_id'));
            $amount = $cart['amount'];
        }
        $currency = get_option('currency_sign');
        $user_id = null;
        if (Auth::check()) {
            $user_id = Auth::user()->id;
        }
        //Create payment in database


        $transaction_id = 'tran_' . time() . str_random(6);
        // get unique recharge transaction id
        while((Payment::whereLocalTransactionId($transaction_id)->count()) > 0) {
            $transaction_id = 'reid' . time() . str_random(5);
        }
        $transaction_id = strtoupper($transaction_id);

        $payments_data = [
            'name' => session('cart.full_name'),
            'email' => session('cart.email'),

            'user_id'               => $user_id,
            'campaign_id'           => $campaign->id,
            'reward_id'             => session('cart.reward_id'),

            'amount'                => $amount,
            'payment_method'        => 'bank_transfer',
            'status'                => 'pending',
            'currency'              => $currency,
            'local_transaction_id'  => $transaction_id,

            'contributor_name_display'  => session('cart.contributor_name_display'),

            'bank_swift_code'   => $request->bank_swift_code,
            'account_number'    => $request->account_number,
            'branch_name'       => $request->branch_name,
            'branch_address'    => $request->branch_address,
            'account_name'      => $request->account_name,
            'iban'              => $request->iban,
        ];
        //Create payment and clear it from session
        $created_payment = Payment::create($payments_data);
        $request->session()->forget('cart');

        return ['success' => 1, 'msg' => trans('app.payment_received_msg'), 'response' => $this->payment_success_html()];

    }


}
