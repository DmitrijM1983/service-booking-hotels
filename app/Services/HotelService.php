<?php

namespace App\Services;

use App\Models\Hotel;
use Carbon\Carbon;

class HotelService
{
    /**
     * @param int $id
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getHotelInfo(int $id, string $startDate, string $endDate): array
    {
        /** @var Hotel $hotel */
        $hotel = Hotel::find($id);
        $rooms = $hotel->rooms;

        $startDate = Carbon::createFromFormat('Y-m-d', $startDate);
        $endDate = Carbon::createFromFormat('Y-m-d', $endDate);
        $days = $startDate->diffInDays($endDate);

        return [
            'hotel' => $hotel,
            'rooms' => $rooms,
            'days' => $days
        ];
    }
}
