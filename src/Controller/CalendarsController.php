<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\CalendarService;
use Cake\Controller\Controller;

class CalendarsController extends Controller
{
    public function index(CalendarService $calendars)
    {
        $this->log('to the logs!');
        $this->set('calendars', $calendars->getCalendarList());
    }
}
