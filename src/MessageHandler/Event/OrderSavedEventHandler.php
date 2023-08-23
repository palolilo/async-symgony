<?php

namespace App\MessageHandler\Event;

use App\Message\Event\OrderSavedEvent;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Email;

class OrderSavedEventHandler implements MessageHandlerInterface {

    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }

    /**
     * @throws MpdfException
     * @throws TransportExceptionInterface
     */
    public function __invoke(OrderSavedEvent $event): void {
        // 1 Create Email contact note

        $mpdf = new Mpdf();
        $content = "<h1>Contract Note For Order {$event->getOrderId()}</h1>";
        $content .= "<p>Total: <b>$1800,50</b</p>";

        $mpdf->writeHtml($content);

        $contentNotePdf = $mpdf->output('','S');

        // 2 Email the contract note to the buyer
        $email = (new Email())
            ->from('sales@pkmeto.com')
            ->to('pkmeto@pkmeto.com')
            ->subject($event->getOrderId())
            ->text('Here is your contract note.')
            ->attach($contentNotePdf,'contract-note.pdf')
        ;

        $this->mailer->send($email);
    }



}