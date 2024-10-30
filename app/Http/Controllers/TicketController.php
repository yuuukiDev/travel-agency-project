<?php

namespace App\Http\Controllers;

use App\Services\TicketService;
use App\Utils\APIResponder;

class TicketController extends Controller
{
    use APIResponder;

    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function send($orderId)
    {
        try {
            $data = $this->ticketService->generateAndSendTicket($orderId);

            return $this->successResponse($data, 'Ticket generated and sent successfully');
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function download($orderId)
    {
        return $this->ticketService->downloadTicket($orderId);
    }
}
