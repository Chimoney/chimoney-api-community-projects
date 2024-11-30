<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OptionsSeeder extends Seeder 
{

    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run() 
    {
        $options = [
            'currency_sign' => 'USD',
            'currency_position' => 'left',
            'date_format' => 'd/m/Y',
            'time_format' => 'H:i',
            'site_name' => 'Harambee',
            'site_title' => 'Harambee',
            'email_address' => 'admin@demo.com',
            'default_timezone' => 'Africa/Nairobi',
            'date_format_custom' => 'd/m/Y',
            'time_format_custom' => 'H:i',
            'additional_css' => NULL,
            'additional_js' => NULL,

            'banner_main_header' => 'Harambee Crowdfunding Platform',
            'banner_sub_header' => 'Effortlessly have your own world class professional fund raising platform that is expertly crafted by the world best software developers. ',
            'footer_about_us' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.',
            'footer_address' => '<li><i class=\"fa fa-map-marker\"></i> <span>4122 Riverside Drive <br /> Clarkesville, GA 30523 <br /> United States</span></li> <li><i class=\"fa fa-phone\"></i> <span>+01 234 567890</span></li> <li><i class=\"fa fa-envelope-o\"></i> <span>demo@themeqx.com</span></li>',
            'copyright_text' => '[copyright_sign] [year] [site_name], All rights reserved.',
            'logo' => 'logo.png',
            'logo_settings' => 'show_image',

            'enable_social_login' => '1',
             'enable_facebook_login' => '1',
            'enable_google_login' => '1',
            'fb_app_id' => '807346162754117',
            'fb_app_secret' => '6b93030d5c4f2715aa9d02be93256fbd',
            'google_client_id' => '62019812075-0sp3u7h854tp7aknl1m8q7ens0pm4im0.apps.googleusercontent.com',
            'google_client_secret' => 'xK8SHn-ds4GJtVSL95ExTzw3',

            'campaign_owner_commission' => '80',
            'enable_disqus_comment' => '0',
            'disqus_shortname' => 'tclassifieds',

            'enable_stripe' => '1',
            'stripe_test_mode' => '1',
            'stripe_test_secret_key' => 'sk_test_tJeAdA1KbhiYV8I8bfPmJcOL',
            'stripe_test_publishable_key' => 'pk_test_P3TFmKrvT7l29Zpyy1f4pwk8',
            'stripe_live_secret_key' => NULL,
            'stripe_live_publishable_key' => NULL,
            'enable_paypal' => '1',
            'enable_paypal_sandbox' => '1',
            'paypal_receiver_email' => 'MerchantKennethNBoyd@teleworm.us',
            'enable_bank_transfer' => '1',
            'bank_swift_code' => 'USDIIEDH',
            'account_number' => '9879878798798',
            'branch_name' => 'Bank of America',
             'branch_address' => '7510 147th St W Apple Valley, MN 55124',
            'account_name' => 'Dinger Brad',
            'iban' => '2343',

            'enable_recaptcha_login' => '0',
            'recaptcha_site_key' => '6LfSyyMUAAAAAPA6f8iIP7WB51Bw3xKipBHlvdz_',
            'recaptcha_secret_key' => '6LfSyyMUAAAAAHeMy-PyshlTJcbE3sbsddOGw6gk',
            'enable_recaptcha_registration' => '0',
            'enable_recaptcha_contact_form' => '0',

            'cookie_message' => 'This website uses cookies and other tracking tools to provide you with the best experience. By using our site, you acknowledge that you understand this and are willing to comply with the terms in our privacy policy.',
            'cookie_learn_page' => '1'
        ];
        
        foreach ($options as $key => $value) {
            \DB::table('options')->insert([
                'option_key' => $key,
                'option_value' => $value
            ]);
        }
    }
}
