<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name')->nullable();
            $table->string('bank_number')->nullable();
            $table->string('bank_image')->nullable();
            $table->string('phone_contact')->nullable();
            $table->string('about_contact')->nullable();
            $table->string('address_contact')->nullable();
            $table->string('email_contact')->nullable();
            $table->integer('point')->default(1);
            $table->integer('amount')->default(1);
            $table->string('pusher_app_id')->nullable();
            $table->string('pusher_app_key')->nullable();
            $table->string('pusher_app_secret')->nullable();
            $table->string('pusher_app_cluster')->nullable();

            $table->boolean('is_login_only_one_device')->default(0);
            $table->text('privacy_policy_html')->nullable();
            $table->text('terms_of_use_html')->nullable();
            $table->bigInteger('default_shipping_fee')->default(0);

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
        Schema::dropIfExists('settings');
    }
}
