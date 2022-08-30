<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccomodationSponsorPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accomodation_sponsor_plan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('accomodation_id');
            $table->foreign('accomodation_id')
                ->references('id')
                ->on('accomodations');
            $table->unsignedBigInteger('sponsor_plan_id');
            $table->foreign('sponsor_plan_id')
                ->references('id')
                ->on('sponsor_plans');

            $table->dateTime('creating_date');
            $table->dateTime('expiring_date');
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
        Schema::dropIfExists('accomodation_sponsor_plan');
    }
}
