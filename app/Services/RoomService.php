<?php

namespace App\Services;

use App\Models\Room;

class RoomService
{
    /**
     * @param int $hotelId
     * @return array
     */
    public static function getRoomIds(int $hotelId): array
    {
        $rooms = Room::query()->where('hotel_id', '=', $hotelId)->get()->toArray();

        $roomIds = [];

        foreach ($rooms as $room) {
            foreach ($room as $key=>$value) {
                if ($key === 'id') {
                    $roomIds[] = $value;
                }
            }
        }
        return $roomIds;
    }
}
