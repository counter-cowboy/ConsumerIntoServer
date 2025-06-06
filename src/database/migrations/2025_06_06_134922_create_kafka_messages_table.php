<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       DB::connection('clickhouse')->statement("
       CREATE TABLE IF NOT EXISTS kafka_messages(
           timestamp DateTime,
                topic String,
                partition UInt32,
                offset UInt64,
                message String
       ) ENGINE =MergeTree()
       ORDER BY timestamp
       ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kafka_messages');
    }
};
