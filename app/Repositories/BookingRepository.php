<?php

namespace App\Repositories;

use App\Booking;
use App\Mail\AcceptBookingRequestNotification;
use App\Mail\BookingRequestNotification;
use App\Mail\DeclineBookingRequestNotification;
use App\Mail\RescheduleBookingRequestNotification;
use App\Table;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class BookingRepository.
 */
class BookingRepository extends BaseRepository
{
    public $status = 200;

    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Booking::class;
    }

    public function getBooking()
    {
        if (auth()->user()->role == 'admin') {
            return Booking::all();
        } else {
            return Booking::where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }
    public function getBookingConfirmed()
    {
        return Booking::where('status', 'accepted')->get();
    }
    public function getBookingPending()
    {
        return Booking::where('status', 'pending')->get();
    }

    public function storeBooking($request)
    {
        Mail::to('vicajobs@gmail.com')->send(new BookingRequestNotification());

        $table         = Table::find($request['table']);
        $table->status = 'Book';
        $table->save();

        return Booking::create([
            'user_id' => Auth::id(),
            'table_id' => $request['table'],
            'date' => $request['date'],
            'time' => $request['time']
        ]);
    }

    public function updateBooking($request, $booking)
    {
        $booking->table_id = $request->tableId;
        $booking->status   = $request->status;

        if ($request->status == 'accepted') {

            $table         = Table::find($request['tableId']);
            $table->status = 'Occupied';
            $table->save();

            Mail::to($booking->user->email)->send(new AcceptBookingRequestNotification());
        } else if ($request->status == 'declined') {
            Mail::to($booking->user->email)->send(new DeclineBookingRequestNotification());
        } else if ($request->status == 'rescheduled'){
            $booking->date   = $request->date;
            $booking->time   = $request->time;

            Mail::to($booking->user->email)->send(new RescheduleBookingRequestNotification());
        }

        return $booking->save();
    }
}
