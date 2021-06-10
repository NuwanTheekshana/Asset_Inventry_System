<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetUnallocatedTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_unallocated_tbls', function (Blueprint $table) {
            $table->id();
            $table->string('asset_type');
            $table->string('asset_no');
            $table->string('serial_no');
            $table->string('asset_model');
            $table->string('other_asset_model');
            $table->string('other_asset_capacity');
            $table->string('resposible_user_id');
            $table->string('resposible_user_epf');
            $table->string('resposible_user_name');
            $table->string('asset_condition');
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
        Schema::dropIfExists('asset_unallocated_tbls');
    }
}
