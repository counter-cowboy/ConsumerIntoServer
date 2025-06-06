<?php

namespace App\Console\Commands;

use App\Consumers\StoreEventConsumer;
use ClickHouseDB\Client;
use Illuminate\Console\Command;
use Junges\Kafka\Commit\Committer;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\MessageConsumer;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\ConsumedMessage;

class ConsumeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kafka consume';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Starting consume for topic");
        Kafka::consumer(['topic'])
            ->withBrokers('77.221.136.155:9092')
            ->withHandler(function (ConsumedMessage $message) {
                $body = $message->getBody();
                $data = json_decode($body, true);

                if ($data === null) {
                    $this->info("Received = " . $body);
                } else {
                    $this->info("received:" . $data['data'] ?? json_encode($data));
                }

                $config = config('database.connections.clickhouse');
                $db = new Client($config);
                $db->database('less');
                $db->write(
                    "
       CREATE TABLE IF NOT EXISTS kafka_messages(
           timestamp DateTime,
                topic String,
                partition UInt32,
                offset UInt64,
                message String
       ) ENGINE = MergeTree()
       ORDER BY timestamp
       "
                );


                $db->insert('kafka_messages', [
                    [
                        'timestamp' => date('Y-m-d H:i:s'),
                        'topic' => $message->getTopicName(),
                        'partition' => $message->getPartition(),
                        'offset' => $message->getOffset(),
                        'message' => $body
                    ]
                ]);
            })
            ->build()->consume();
    }
}
