<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Post;
use App\Mail\ContactUs;
use App\Mail\ContactUsSendToSender;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $title = get_option('banner_main_header');
        
        $categories = Category::orderBy('category_name', 'asc')->take(8)->get();
        $new_campaigns = Campaign::active()->orderBy('id', 'desc')->paginate(8);
        $funded_campaigns = Campaign::active()->funded()->orderBy('id', 'desc')->take(8)->get();
        
        $new_campaigns->withPath('ajax/new-campaigns');

        $campaigns_count = Campaign::all()->count();
        $users_count = User::all()->count();
        $fund_raised_count = Payment::whereStatus('success')->sum('amount');

        return view('public.home', compact('title','categories', 'new_campaigns', 'funded_campaigns', 'campaigns_count', 'users_count', 'fund_raised_count'));
    }
    
    public function showPage($slug){
        $page = Post::whereSlug($slug)->first();

        if (! $page){
            return view('theme.error_404');
        }
        $title = $page->title;
        return view('public.pages.show', compact('title', 'page'));
    }

    public function contactUs(){
        $title = trans('app.contact_us');
        return view('public.pages.contact_us', compact('title'));
    }

    public function contactUsPost(Request $request){
        $rules = [
            'name'  => 'required',
            'email'  => 'required|email',
            'subject'  => 'required',
        ];
        if (get_option('enable_recaptcha_contact_form') == 1){
            $rules['g-recaptcha-response'] = 'required';
        }
        $this->validate($request, $rules);

        if (get_option('enable_recaptcha_contact_form') == 1) {
            $secret = get_option('recaptcha_secret_key');
            $gRecaptchaResponse = $request->input('g-recaptcha-response');
            $remoteIp = $request->ip();

            $recaptcha = new \ReCaptcha\ReCaptcha($secret);
            $resp = $recaptcha->verify($gRecaptchaResponse, $remoteIp);
            if (!$resp->isSuccess()) {
                return redirect()->back()->with('error', 'reCAPTCHA is not verified');
            }
        }

        try{
            Mail::send(new ContactUs($request));
            Mail::send(new ContactUsSendToSender($request));
        }catch (\Exception $exception){
            return redirect()->back()->with('error', '<h4>'.trans('app.smtp_error_message').'</h4>'. $exception->getMessage());
        }

        return redirect()->back()->with('success', trans('app.message_has_been_sent'));
    }


    public function acceptCookie(Request $request){
        return response(['accept_cookie' => true])->cookie('accept_cookie', true, 43800);
    }


    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * Clear all cache
     */
    public function clearCache(){
        Artisan::call('debugbar:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        if (function_exists('exec')){
            exec('rm ' . storage_path('logs/*'));
        }
        $this->rrmdir(storage_path('logs/'));

        return redirect(route('home'));
    }
    public function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir."/".$object))
                        $this->rrmdir($dir."/".$object);
                    else
                        unlink($dir."/".$object);
                }
            }
            //rmdir($dir);
        }
    }


}
