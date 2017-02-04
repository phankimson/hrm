<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormVoucher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('form_voucher', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('name');
            $table->string('code');
            $table->string('subject');
            $table->longtext('content');
            $table->tinyInteger('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
