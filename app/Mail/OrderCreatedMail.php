<?php

namespace App\Mail;

use App\Models\Order;          
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;        // сделаем заказ доступным в blade

    /* ───────── 1. Конструктор ───────── */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /* ───────── 2. Заголовок письма ───────── */
    public function envelope(): \Illuminate\Mail\Mailables\Envelope
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: 'Ваш заказ №' . $this->order->id . ' принят'
        );
    }

    /* ───────── 3. Контент письма ───────── */
    public function content(): \Illuminate\Mail\Mailables\Content
    {
        return new \Illuminate\Mail\Mailables\Content(
            view: 'emails.order_created'   // resources/views/emails/order_created.blade.php
        );
    }

    /* attachments() можешь оставить пустым */
    public function attachments(): array
    {
        return [];
    }
}
