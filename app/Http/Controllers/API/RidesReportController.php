<?php namespace App\Http\Controllers\API;

use App\Models\Booking;
use Illuminate\Database\Query\Builder as QueryBuilder;

class RidesReportController {

    public function index()
    {
        return \DB::table('drivers', 'd')
            ->select([ 'd.driver_id' ])
            ->addSelect([
                'number_of_completed_rides' => function (QueryBuilder $query) {
                    $query->from('bookings', 'b1')
                        ->where('b1.state', '=', Booking::COMPLETED_STATE)
                        ->whereColumn('b1.driver_id', '=', 'd.driver_id')
                        ->selectRaw('COUNT(*)');
                },
                'number_of_cancelled_rides' => function (QueryBuilder $query) {
                    $query->from('bookings', 'b2')
                        ->where('b2.state', '=', Booking::CANCELLED_DRIVER_STATE)
                        ->whereColumn('b2.driver_id', '=', 'd.driver_id')
                        ->selectRaw('COUNT(*)');
                },
                'number_of_unique_passengers' => function (QueryBuilder $query) {
                    $query->from('bookings', 'b3')
                        ->where('b3.state', '=', Booking::COMPLETED_STATE)
                        ->whereColumn('b3.driver_id', '=', 'd.driver_id')
                        ->selectRaw('COUNT(DISTINCT passenger_id)');
                },
                'total_fare' => function (QueryBuilder $query) {
                    $query->from('bookings', 'b4')
                        ->where('b4.state', '=', Booking::COMPLETED_STATE)
                        ->whereColumn('b4.driver_id', '=', 'd.driver_id')
                        ->selectRaw('SUM(fare)');
                },
                'total_commission' => function (QueryBuilder $query) {
                    $query->from('bookings', 'b5')
                        ->where('b5.state', '=', Booking::COMPLETED_STATE)
                        ->whereColumn('b5.driver_id', '=', 'd.driver_id')
                        ->selectRaw('round(SUM(fare) * 0.2, 2)');
                },
            ])
            ->where(function (QueryBuilder $query) {
                $query->where('email', 'LIKE', '%fvtaxi%')
                    ->orWhere('email', 'LIKE', '%fvdrive%');
            })
            ->orderBy('number_of_completed_rides', 'DESC')
            ->having('number_of_completed_rides', '>', 10)
            ->having('number_of_unique_passengers', '<', 5)
            ->get();
    }

}
