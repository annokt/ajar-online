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
            $table->integer('billing_address_id');
            $table->string('prefix', 8);
            $table->integer('number');
            $table->string('currency', 3);
            $table->timestamp('due_at');
            $table->integer('status')->default(0);
            $table->text('note')->nullable();
            $table->string('language', 2)->nullable();
            $table->integer('sub_total')->nullable();
            $table->integer('total')->nullable();
            $table->integer('tax_registration_number')->nullable();
            $table->unsignedInteger('user_id')->nullable();
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
