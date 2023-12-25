<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->dateTime('date_of_birth')->nullable();
            $table->string('password');
            $table->string('firebase_uid')->nullable();
            $table->bigInteger('user_status_id')->default(1);
            $table->bigInteger('role_id');
            $table->tinyInteger('is_admin')->default(0);
            $table->tinyInteger('gender_id')->default(1);

            $table->string('provider_name')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('password')->nullable()->change();
//            $table->string('avatar')->nullable();

            $table->integer('user_type_id')->default(1);
            $table->bigInteger('referral_id')->default(0);
            $table->bigInteger('point')->default(0);
            $table->bigInteger('amount')->default(0);

            $table->bigInteger('city_id')->default(0);
            $table->bigInteger('district_id')->default(0);
            $table->bigInteger('ward_id')->default(0);
            $table->string('address')->nullable();

            $table->rememberToken();
            $table->timestamp('last_seen')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
