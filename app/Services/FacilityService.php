<?php

namespace App\Services;

use DB;

class FacilityService
{
    /**
     * @param array $facilities
     * @param int $roomId
     * @return void
     */
    public static function editRoomFacilities(array $facilities, int $roomId): void
    {
        DB::table('facility_room')->where('room_id', '=', $roomId)->delete();

        foreach ($facilities as $facility)
        {
            DB::table('facility_room')->insert([
                'facility_id' => $facility,
                'room_id' => $roomId
            ]);
        }
    }

    /**
     * @param array $facilities
     * @param int $hotelId
     * @return void
     */
    public static function editHotelFacilities(array $facilities, int $hotelId): void
    {
        DB::table('facility_hotel')->where('hotel_id', '=', $hotelId)->delete();

        foreach ($facilities as $facility)
        {
            DB::table('facility_hotel')->insert([
                'facility_id' => $facility,
                'hotel_id' => $hotelId
            ]);
        }
    }
}
