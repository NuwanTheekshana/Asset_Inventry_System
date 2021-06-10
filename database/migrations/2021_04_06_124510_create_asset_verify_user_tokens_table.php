<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetVerifyUserTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_verify_user_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('ref_no');
            $table->string('user_epf_no');
            $table->string('user_name');
            $table->string('nic_no');
            $table->string('company');
            $table->string('user_token');
            $table->string('asset_status');
            $table->string('asset_token');
            $table->string('dongle_status');
            $table->string('dongle_token');
            $table->string('status')->default(1);
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
        Schema::dropIfExists('asset_verify_user_tokens');
    }
}
