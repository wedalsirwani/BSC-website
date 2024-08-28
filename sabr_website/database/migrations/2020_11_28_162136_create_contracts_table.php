<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->integer("apartment_id");
            $table->integer("renter_id");
            $table->string("start_date");
            $table->string("hijri_start_date");
            $table->string("end_date");
            $table->string("hijri_end_date");
            $table->string("rent_duration");
            $table->string("rent_unit");
            $table->string("rent_amount");
            $table->boolean("active")->default(0);
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
        Schema::dropIfExists('contracts');
    }
}
