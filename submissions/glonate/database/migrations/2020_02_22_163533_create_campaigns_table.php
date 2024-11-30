<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('campaign_owner_commission')->nullable();
            $table->decimal('goal', 16,2)->nullable();
            $table->decimal('min_amount', 16,2)->nullable();
            $table->decimal('max_amount', 16,2)->nullable();
            $table->decimal('recommended_amount', 16,2)->nullable();
            $table->decimal('total_funded', 16,2)->nullable();
            $table->integer('total_payments')->nullable();
            $table->string('amount_prefilled')->nullable();
            $table->string('end_method', 20)->nullable();
            $table->integer('views')->nullable();
            $table->string('video')->nullable();
            $table->string('feature_image')->nullable();
            $table->tinyInteger('status')->nullable(); //0:pending,1:approve,2:blocked
            $table->mediumInteger('country_id')->nullable();
            $table->string('address')->nullable();

            $table->tinyInteger('is_funded')->nullable(); //0:pending,1:approve,2:blocked
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamp('total_funded_last_upated_at')->nullable();

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
        Schema::dropIfExists('campaigns');
    }
}
