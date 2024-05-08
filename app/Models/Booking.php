<?php

namespace App\Models;

use App\Services\RoomService;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'user_id',
        'started_at',
        'finished_at',
        'days',
        'price'
    ];

    /**
     * @return BelongsTo
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * @return BelongsTo
     */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * @return BelongsTo
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param int $id
     * @return int
     */
    public function deleteBooking(int $id): int
    {
        return DB::table('bookings')->where('id', '=', $id)->delete();
    }

    /**
     * @param int $hotelId
     * @return void
     */
    public static function deleteBookingFromHotelId(int $hotelId): void
    {
        $roomIds = RoomService::getRoomIds($hotelId);
        foreach ($roomIds as $id) {
            Booking::where('room_id', '=', $id)->delete();
        }
    }
}
