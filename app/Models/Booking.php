<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Booking
 *
 * @property int $booking_id
 * @property string $created_at_local
 * @property int $driver_id
 * @property int $passenger_id
 * @property string $state
 * @property int $country_id
 * @property string $fare
 * @property-read \App\Models\Driver $driver
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCreatedAtLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereDriverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereFare($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking wherePassengerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereState($value)
 * @mixin \Eloquent
 */
class Booking extends Model {

    use HasFactory;

    public const COMPLETED_STATE = 'COMPLETED';

    public const CANCELLED_PASSENGER_STATE = 'CANCELLED_PASSENGER';

    public const CANCELLED_DRIVER_STATE = 'CANCELLED_DRIVER';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'booking_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'driver_id');
    }

    public static function randomState() : string
    {
        $states = [
            self::COMPLETED_STATE,
            self::CANCELLED_PASSENGER_STATE,
            self::CANCELLED_DRIVER_STATE,
        ];

        return $states[array_rand($states)];
    }

}
