<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function reservations()
    {
        return view('admin.bookings.reservations')->with('data', Booking::reservations()->get());
    }

    public function appointments()
    {
        return view('admin.bookings.appointments')->with('data', Booking::appointments()->get());
    }

    public function create_reservation()
    {
        return view('pages.reservation');
    }

    public function create_appointment()
    {
        return view('pages.appointment');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:250',
            'email' => 'required|max:250',
            'phone' => 'required|max:250',
            'persons' => 'required|numeric',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'info' => 'sometimes',
            'type' => 'required|in:1,2',
        ]);
        Booking::create($data);
        // $this->add_to_landing_page_contact($data);
        return back()->with('success', $data['type'] == 1 ? 'You reserved a table successfully' : 'You made a appointment successfully');
    }

    protected function add_to_landing_page_contact($data)
    {
        $exists = DB::table('landing_page_contacts')->where('email', $data['email'])->exists();
        if (!$exists) {
            DB::table('landing_page_contacts')->insert([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
            ]);
        }
    }

    public function update_status(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,cancel,accept',
        ]);
        $booking->update($data);
        return back()->with('success', $booking->type == 1 ? 'Reservation status updated successfully' : 'Appointment status updated successfully');
    }

    public function update(Request $request, Booking $booking)
    {
    }

    public function destroy(Booking $booking)
    {
        $type = $booking->type;
        $booking->delete();
        return back()->with('success', $type == 1 ? 'Reservation deleted successfully' : 'Appointment deleted successfully');
    }
}
