<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommonConnectionDetailsTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_connection_details_tbls', function (Blueprint $table) {
            $table->id();
            $table->string('dongle_connection_type');
            $table->string('dongle_connection_no');
            $table->string('dongle_sim_no');
            $table->string('dongle_ip_address');
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
        Schema::dropIfExists('common_connection_details_tbls');
    }
}
