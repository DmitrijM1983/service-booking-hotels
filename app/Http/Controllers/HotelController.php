<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Facility;
use App\Models\Hotel;
use App\Models\Room;
use App\Services\FacilityService;
use App\Services\HotelService;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HotelController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $hotels = Hotel::all();

        return view('hotels.index', ['hotels' => $hotels]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return View
     */
    public function show(int $id, Request $request): View
    {
        $startDate = $request->get('start_date', date('Y-m-d'));
        $endDate = $request->get('end_date',   date('Y-m-d' , time() + 86400));
        $service = new HotelService();
        $data = $service->getHotelInfo($id, $startDate, $endDate);

        if($request->all() != []) {
            return view('hotels.show', [
                'hotel' => $data['hotel'],
                'rooms' => $data['rooms'],
                'days' => $data['days'],
                'startDate' => $startDate,
                'endDate' => $endDate
            ]);
        }
        return view('hotels.show', [
            'hotel' => $data['hotel'],
            'rooms' => $data['rooms']
        ]);
    }

    /**
     * @return View
     */
    public function addHotel(): View
    {
        return view('hotels.add_hotel');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function saveHotel(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'min:5|max:20|required',
            'description' => 'min:5|max:50|required',
            'poster_url' => 'max:100|required',
            'address' => 'max:50|required'
        ]);

        $hotelData = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'poster_url' => $request->get('poster_url'),
            'address' => $request->get('address')
        ];

        Hotel::insert($hotelData);

        return redirect()->route('hotels.index');
    }


    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        Booking::deleteBookingFromHotelId($id);
        Room::deleteRoomFromHotelId($id);
        DB::table('facility_hotel')->where('hotel_id', '=', $id)->delete();
        Hotel::where('id', '=', $id)->delete();

        return redirect()->route('hotels.index');
    }

    /**
     * @param int $hotelId
     * @return View
     */
    public function addRoom(int $hotelId): View
    {
        return view('rooms.add_room', ['hotel_id' => $hotelId]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function saveRoom(Request $request)
    {
        $request->validate([
            'title' => 'min:5|max:20',
            'description' => 'min:5|max:50',
            'poster_url' => 'max:100'
        ]);

        $roomData = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'poster_url' => $request->get('poster_url'),
            'flour_area' => $request->get('flour_area'),
            'price' => $request->get('price'),
            'hotel_id' => $request->get('hotel_id')
        ];

        Room::insert($roomData);

        return redirect()->route('hotels.show', $request->get('hotel_id'));
    }

    /**
     * @param int $roomId
     * @return View
     */
    public function editRoomFacilities(int $roomId): View
    {
        $facilities = Facility::all()->toArray();

        return view('facilities.room_facilities', ['facilities' => $facilities, 'room_id' => $roomId]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function saveRoomFacilities(Request $request): RedirectResponse
    {
        $facilities = [];
        foreach($request->all() as $key=>$item) {
            if (is_int($key)) {
                $facilities[] = $key;
            }
        }

        FacilityService::editRoomFacilities($facilities, $request->get('room_id'));

        return redirect()->route('hotels.index');
    }

    /**
     * @param int $hotelId
     * @return View
     */
    public function editHotelFacilities(int $hotelId): View
    {
        $facilities = Facility::all()->toArray();

        return view('facilities.hotel_facilities', ['facilities' => $facilities, 'hotel_id' => $hotelId]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function saveHotelFacilities(Request $request): RedirectResponse
    {
        $facilities = [];
        foreach($request->all() as $key=>$item) {
            if (is_int($key)) {
                $facilities[] = $key;
            }
        }

        FacilityService::editHotelFacilities($facilities, $request->get('hotel_id'));

        return redirect()->route('hotels.index');
    }
}
