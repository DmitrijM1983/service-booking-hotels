<?php

namespace App\Models;

use App\Services\RoomService;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'poster_url',
        'flour_area',
        'price',
        'hotel_id'
    ];

    /**
     * @param int $hotelId
     * @return Collection|array
     */
    public static function getRooms(int $hotelId): Collection|array
    {
        return self::query()->where('hotel_id', '=', $hotelId)->get();
    }

    /**
     * @return BelongsToMany
     */
    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'facility_room', 'room_id', 'facility_id');
    }

    /**
     * @param int|string $days
     * @return float
     */
    public function getTotalPrice(int|string $days): float
    {
        $days = intval($days);
        return round($this->price * $days, 2);
    }

    /**
     * @return BelongsTo
     */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * @param int $hotelId
     * @return void
     */
    public static function deleteRoomFromHotelId(int $hotelId): void
    {
        $roomIds = RoomService::getRoomIds($hotelId);
        foreach ($roomIds as $id) {
            DB::table('facility_room')->where('room_id', '=', $id)->delete();
            Room::where('id', '=', $id)->delete();
        }
    }
}
