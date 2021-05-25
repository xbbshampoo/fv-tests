<?php

use App\Models\Booking;
use App\Models\Driver;
use Illuminate\Database\Migrations\Migration;

class AddDriverAndBookingSeededData extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $dbDumpPath = storage_path('db_dump.sql');
        $sqlQuery = file_get_contents($dbDumpPath);

        \DB::unprepared($sqlQuery);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
