<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayablePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payable_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('contract_id');
            $table->double('amount');
            $table->string('payable_date');
            $table->string('payable_H_date');
            $table->string('status')->default('non_payable');
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
        Schema::dropIfExists('payable_payments');
    }
}
