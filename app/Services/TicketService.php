<?php

namespace App\Services;

use App\Mail\TicketMail;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class TicketService
{
    public function sendEmail($ticketId, $userName, $tourDetails, $totalQuantity, $orderId)
    {
        Mail::to(config('app.admin_email'))
            ->send(
                new TicketMail(
                    $ticketId,
                    $userName,
                    $tourDetails,
                    $totalQuantity,
                    $orderId)
            );
    }

    public function getData($orderId)
    {
        $order = Order::with('items.tour', 'user')->findOrFail($orderId);

        $ticketId = strtoupper(uniqid('TKT'));

        return [
            'ticketId' => $ticketId,
            'userName' => $order->user->name,
            'tourDetails' => $order->items,
            'totalQuantity' => $order->items->sum('qty'),
            'orderId' => $orderId,
        ];
    }

    public function generateAndSendTicket($orderId)
    {
        $data = $this->getData($orderId);

        $this->sendEmail($data['ticketId'], $data['userName'], $data['tourDetails'], $data['totalQuantity'], $data['orderId']);

        return $data;
    }

    public function downloadTicket($orderId)
    {
        $data = $this->getData($orderId);

        $data['isPdf'] = true;

        $pdf = Pdf::loadView('mail.ticket', $data);

        return $pdf->download('ticket_'.$data['ticketId'].'.pdf');
    }
}
