<?php

namespace App\Http\Controllers\api;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Repositories\BookingRepository;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $booking;

    public function __construct(BookingRepository $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $booking = $this->booking->getBooking();

        $result = [
            'booking' => $booking
        ];

        return response()->json($result, $this->booking->status, [], JSON_PRETTY_PRINT);
    }

    public function confirmedBooking()
    {
        $booking = $this->booking->getBookingConfirmed();

        $result = [
            'booking' => $booking
        ];

        return response()->json($result, $this->booking->status, [], JSON_PRETTY_PRINT);
    }
    public function pendingBooking()
    {
        $booking = $this->booking->getBookingPending();

        $result = [
            'booking' => $booking
        ];

        return response()->json($result, $this->booking->status, [], JSON_PRETTY_PRINT);
    }

    public function newBooking()
    {
        return view('booking.new-booking');
    }

    public function customerBooking()
    {
        return view('booking.customer.booking-list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $booking = $this->booking->storeBooking($request);

        $result = [
            'booking' => $booking
        ];

        return response()->json($result, $this->booking->status, [], JSON_PRETTY_PRINT);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        $booking = $this->booking->updateBooking($request, $booking);

        $result = [
            'booking' => $booking
        ];

        return response()->json($result, $this->booking->status, [], JSON_PRETTY_PRINT);
    }
}
