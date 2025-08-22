<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class BookingController extends Controller
{

    public function generatePdf($id)
    {
        $event = Event::with([
            'department',
            'location',
            'eventType',
            'user',
            'meals',
            'meals.specialGuest',
            'meals.servingMethod',
            'meals.details.mealSession'
        ])->findOrFail($id);


        $pdf = Pdf::loadView('pdf.booking-details', compact('event'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('booking-details-' . $event->id . '.pdf');
    }
}
