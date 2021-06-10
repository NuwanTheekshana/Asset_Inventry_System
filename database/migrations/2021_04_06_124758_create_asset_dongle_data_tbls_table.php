<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetDongleDataTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_dongle_data_tbls', function (Blueprint $table) {
            $table->id();
            $table->string('dongle_token');
            $table->string('dongle_asset_type');
            $table->string('dongle_connection_type');
            $table->string('dongle_connection_no');
            $table->string('dongle_sim_no');
            $table->string('dongle_ip_address');
            $table->string('dongle_modal');
            $table->string('dongle_imei_no');
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
        Schema::dropIfExists('asset_dongle_data_tbls');
    }
}
