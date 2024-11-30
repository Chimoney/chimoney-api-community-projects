<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawalPreference extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawal_preferences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();

            $table->string('default_withdrawal_account')->nullable();
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
        Schema::dropIfExists('withdrawal_preferences');
    }
}
