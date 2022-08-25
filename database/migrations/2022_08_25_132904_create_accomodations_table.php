<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccomodationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accomodations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->text('description');
            $table->unsignedTinyInteger('n_rooms');
            $table->unsignedTinyInteger('n_beds');
            $table->unsignedTinyInteger('n_bathrooms');
            $table->unsignedInteger('size_sqm');
            $table->string('address', 255);
            $table->double('latitude', 10, 8);
            $table->double('longitude', 11, 8);
            $table->text('image');
            $table->boolean('is_visible')->default(1);
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
        Schema::dropIfExists('accomodations');
    }
}
