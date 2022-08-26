<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccomodationFacilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accomodation_facility', function (Blueprint $table) {
            $table->unsignedBigInteger('accomodation_id');
            $table->foreign('accomodation_id')
                ->references('id')
                ->on('accomodations');

            $table->unsignedBigInteger('facility_id');
            $table->foreign('facility_id')
                ->references('id')
                ->on('facilities');

            $table->primary(['accomodation_id', 'facility_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accomodation_facility');
    }
}
