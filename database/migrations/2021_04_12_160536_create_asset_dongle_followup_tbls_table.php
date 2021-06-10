<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetDongleFollowupTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_dongle_followup_tbls', function (Blueprint $table) {
            $table->id();
            $table->string('current_user_token');
            $table->string('current_user_epf');
            $table->string('current_user_name');
            $table->string('current_user_company');
            $table->string('connection_number');
            $table->string('sim_number');
            $table->string('ip_address');
            $table->string('dongle_imei_no');
            $table->string('reason');
            $table->string('reason_remark');
            $table->string('followup_update_user_id');
            $table->string('followup_update_user_name');
            $table->string('status');
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
        Schema::dropIfExists('asset_dongle_followup_tbls');
    }
}
