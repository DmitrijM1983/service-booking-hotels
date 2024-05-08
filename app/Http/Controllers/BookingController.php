<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $bookingData = [
            'room_id' => $request->get('room_id'),
            'user_id' => Auth::user()->id,
            'started_at' => $request->get('started_at'),
            'finished_at' => $request->get('finished_at'),
            'days' => $request->get('days'),
            'price' => $request->get('price')
        ];
        $room = Room::find($request->get('room_id'));
        $hotel = Hotel::find($room->hotel_id);

        mail(Auth::user()->email, 'Бронирование',
            'Здравствуйте, ' . Auth::user()->full_name . '!
            Вы забронировали номер <<' .  $room->title . '>>, в отеле <<' . $hotel->title . '>>.
            Дата заезда - ' . $bookingData['started_at'] . '.
            Дата выезда - ' . $bookingData['finished_at'] . '.
            Длительность проживания - ' . $bookingData['days'] . ' суток.
            Стоимость проживания - ' . $bookingData['price'] . ' рублей.');

        Booking::insert($bookingData);

        return redirect()->route('bookings.index', Auth::user()->id);
    }

    /**
     * @param int $userId
     * @return View
     */
    public function showBookings(int $userId): View
    {
        $bookings = Booking::all()->where('user_id', '=', $userId);

        return view('bookings.index', ['bookings' => $bookings]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function showBooking(int $id): View
    {
        $booking = Booking::all()->find($id);

        return view('bookings.show', ['booking' => $booking]);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $booking = new Booking();
        $booking->deleteBooking($id);

        return redirect()->route('bookings.index', Auth::user()->id);
    }
}
