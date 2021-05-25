<?php

use App\Models\Booking;
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
            $table->enum('state', [ Booking::COMPLETED_STATE, Booking::CANCELLED_PASSENGER_STATE, Booking::CANCELLED_DRIVER_STATE ]);
            $table->unsignedInteger('country_id');
            $table->decimal('fare');

            $table->index(['driver_id', 'state', 'passenger_id', 'fare'], 'idx_01');
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
