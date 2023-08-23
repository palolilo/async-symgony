<?php

namespace App\MessageHandler;

use App\Message\PurchaseConfirmationNotification;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;

#[AsMessageHandler]
class PurchaseConfirmationNotificationHandler {


    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }


    /**
     * @throws TransportExceptionInterface
     * @throws MpdfException
     */
    public function __invoke(PurchaseConfirmationNotification $notification): void {
        // 1 Create Email contact note

        $mpdf = new Mpdf();
        $content = "<h1>Contract Note For Order {$notification->getOrderId()}</h1>";
        $content .= "<p>Total: <b>$1800,50</b</p>";

        $mpdf->writeHtml($content);

        $contentNotePdf = $mpdf->output('','S');

        // 2 Email the contract note to the buyer
        $email = (new Email())
            ->from('sales@pkmeto.com')
            ->to('pkmeto@pkmeto.com')
            ->subject($notification->getOrderId())
            ->text('Here is your contract note.')
            ->attach($contentNotePdf,'contract-note.pdf')
        ;

        $this->mailer->send($email);

    }

}