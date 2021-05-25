<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('booking_id');
            $table->dateTime('created_at_local');
            $table->unsignedInteger('driver_id');
            $table->unsignedInteger('passenger_id');
            $table->enum('state', [ 'COMPLETED', 'CANCELLED_PASSENGER', 'CANCELLED_DRIVER' ]);
            $table->unsignedInteger('country_id');
            $table->decimal('fare');
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
        Schema::dropIfExists('bookings');
    }

}
