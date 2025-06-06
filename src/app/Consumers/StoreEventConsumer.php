<?php

namespace App\Consumers;

use Carbon\Exceptions\Exception;
use Junges\Kafka\Exceptions\ConsumerException;
use Junges\Kafka\Facades\Kafka;

class StoreEventConsumer
{
    /**
     * @throws Exception
     * @throws ConsumerException
     */
    public function consumation(): void
    {
        $consumer = Kafka::consumer((array)'topic', null, 'broker');
        $consumer->build();
        $consumer->consume();

    }

}
