<?php

namespace App\MessageHandler;

use App\Message\PurchaseConfirmationNotification;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class PurchaseConfirmationNotificationHandler {

    public function __invoke(PurchaseConfirmationNotification $notification) {
        // 1 Create Email contact note
        echo 'Creating a PDF contract note... <br>';

        // 2 Email the contract note to the buyer
        echo 'Email contract to ' . $notification->getOrder()->getBuyer()->getEmail() . '<br>';
    }

}