<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('user_name', 255);
            $table->string('user_surname', 255);
            $table->string('email', 255)->unique();
            $table->text('message_text');
            $table->unsignedBigInteger('accomodation_id')->nullable();
            $table->foreign('accomodation_id')
                ->references('id')
                ->on('accomodations');
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
        Schema::dropIfExists('messages');
    }
}
