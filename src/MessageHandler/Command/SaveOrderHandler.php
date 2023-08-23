<?php

namespace App\MessageHandler\Command;


use App\Message\Command\SaveOrder;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SaveOrderHandler implements MessageHandlerInterface {

    public function __invoke(SaveOrder $saveOrder) {
        $orderId = 1234;
        echo 'Order being saved' . PHP_EOL;

    }

}