<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeripheralsUnallocatedSerialNoTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peripherals_unallocated_serial_no_tbls', function (Blueprint $table) {
            $table->id();
            $table->integer('unallocated_peripherals_id');
            $table->string('serial_number');
            $table->string('create_user_id');
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
        Schema::dropIfExists('peripherals_unallocated_serial_no_tbls');
    }
}
