<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetFollowupTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_followup_tbls', function (Blueprint $table) {
            $table->id();
            $table->string('current_user_token');
            $table->string('current_user_epf');
            $table->string('current_user_name');
            $table->string('current_user_company');
            $table->string('asset_type');
            $table->string('asset_no');
            $table->string('serial_no');
            $table->string('other_asset_model');
            $table->string('other_asset_capacity');
            $table->string('reason');
            $table->string('reason_remark');
            $table->string('followup_update_user_id');
            $table->string('followup_update_user_epf');
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
        Schema::dropIfExists('asset_followup_tbls');
    }
}
