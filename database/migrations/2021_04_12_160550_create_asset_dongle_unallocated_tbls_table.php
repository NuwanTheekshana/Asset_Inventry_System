<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetDongleUnallocatedTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_dongle_unallocated_tbls', function (Blueprint $table) {
            $table->id();
            $table->string('asset_type');
            $table->string('connection_number');
            $table->string('sim_no');
            $table->string('ipaddress');
            $table->string('connection_type');
            $table->string('dongle_modal');
            $table->string('dongle_imei');
            $table->string('dongle_condition');
            $table->string('resposible_user_id');
            $table->string('resposible_user_epf');
            $table->string('resposible_user_name');
            $table->string('status')->default('1');
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
        Schema::dropIfExists('asset_dongle_unallocated_tbls');
    }
}
