<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeripheralsUnallocatedTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peripherals_unallocated_tbls', function (Blueprint $table) {
            $table->id();
            $table->integer('peripheral_type_id');
            $table->string('peripheral_type');
            $table->decimal('unit_price', 10, 2);
            $table->string('supplier_name');
            $table->string('po_number');
            $table->date('received_date');
            $table->integer('quntity');
            $table->string('pheripherals_condition');
            $table->string('create_user_id');
            $table->string('create_user_epf');
            $table->string('create_user_name');
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
        Schema::dropIfExists('peripherals_unallocated_tbls');
    }
}
