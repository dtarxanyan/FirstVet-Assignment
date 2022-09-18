<?php

namespace App\Http\Controllers;

use App\Repositories\TimeSlotRepository;
use Illuminate\Http\Request;

class TimeSlotController extends Controller
{
    function index(TimeSlotRepository $timeSlotRepository)
    {
        return $timeSlotRepository->getFormattedSlots();
    }
}
