<?php

namespace App\Controller;

use App\Message\PurchaseConfirmationNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class StockTransactionController extends AbstractController {



    //buy
    #[Route('buy', name: 'buy-stocks')]
    public function buy(MessageBusInterface $bus): Response {

        //$notification->getOrder()->getBuyer()->getEmail()

        $order = new class {
            public function getId() {
                return 1;
            }

            public function getBuyer(): object {
                return new class {
                    public function getEmail(): string {
                        return 'pkmeto@pkmeto.com';
                    }
                };
            }
        };

        // 1, Dispatch confirmation message
        $bus->dispatch(new PurchaseConfirmationNotification($order));


        // 2, Display confirmation to the user
        return $this->render('stocks/example.html.twig');
    }

    //sell

}