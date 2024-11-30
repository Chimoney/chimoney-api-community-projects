<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawalRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->nullable();
            $table->integer('campaign_id')->nullable();
            $table->double('total_amount', 10,2);
            $table->double('withdrawal_amount', 10,2);
            $table->double('platform_owner_commission', 10,2);
            $table->string('withdrawal_account')->nullable();
            //Paypal
            $table->string('paypal_email')->nullable();
            //Bank
            $table->string('bank_account_holders_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('swift_code')->nullable();
            $table->string('bank_name_full')->nullable();
            $table->string('bank_branch_name')->nullable();
            $table->string('bank_branch_city')->nullable();
            $table->string('bank_branch_address')->nullable();
            $table->string('country_id')->nullable();
            $table->string('status')->nullable(); //approved,declined,pending

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdrawal_requests');
    }
}
