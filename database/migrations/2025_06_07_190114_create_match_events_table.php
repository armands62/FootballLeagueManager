<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('match_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('match_id');
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('related_player_id')->nullable(); // for assists/substitutions
            $table->string('event_type'); // goal, yellow_card, etc.
            $table->integer('minute');
            $table->timestamps();

            $table->foreign('match_id')->references('id')->on('matches')->onDelete('cascade');
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
            $table->foreign('related_player_id')->references('id')->on('players')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('match_events');
    }
};

