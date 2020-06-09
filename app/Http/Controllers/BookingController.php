<?php

namespace App\Http\Controllers;

use App\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.all-booking');
    }

    public function confirmedBooking()
    {
        return view('pages.admin.confirmed-booking');
    }

    public function newBooking()
    {
        return view('pages.admin.new-booking');
    }

    public function customerBooking()
    {
        return view('pages.customer.my-booking');
    }
}
