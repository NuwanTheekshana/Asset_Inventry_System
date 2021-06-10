<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetDataTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_data_tbls', function (Blueprint $table) {
            $table->id();
            $table->string('asset_token');
            $table->string('asset_type');
            $table->string('asset_no');
            $table->string('asset_serial_no');
            $table->string('asset_model');
            $table->string('other_asset_model');
            $table->string('other_asset_capacity');
            $table->string('asset_validate_status');
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
        Schema::dropIfExists('asset_data_tbls');
    }
}
