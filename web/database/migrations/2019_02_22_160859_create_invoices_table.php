<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('entity');
            $table->string('number');
            $table->unsignedInteger('user_id');
            $table->integer('billing_address_id');
            $table->integer('tax_registration_number');
            $table->string('currency', 3);
            $table->integer('sub_total');
            $table->integer('total');
            $table->timestamp('due_at');
            $table->text('note');
            $table->string('language', 2);
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
        Schema::dropIfExists('invoices');
    }
}
