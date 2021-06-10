<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetUserTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_user_tbls', function (Blueprint $table) {
            $table->id();
            $table->string('user_token');
            $table->string('epf_no');
            $table->string('emplyee_type');
            $table->string('nic_no');
            $table->string('full_name');
            $table->string('designation');
            $table->string('location');
            $table->string('email');
            $table->string('contact_no');
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
        Schema::dropIfExists('asset_user_tbls');
    }
}
