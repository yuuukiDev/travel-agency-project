<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\TicketService;
use App\Utils\APIResponder;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

final class TicketController extends Controller
{
    use APIResponder;

    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function send(int $orderId): JsonResponse
    {
        try {

            $data = $this->ticketService->generateAndSendTicket($orderId);

            return $this->successResponse(
                $data,
                'Ticket generated and sent successfully'
            );

        } catch (Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function download(int $orderId): Response
    {
        return $this->ticketService->downloadTicket($orderId);
    }
}
