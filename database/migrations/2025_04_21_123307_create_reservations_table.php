<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->string('name'); 
            $table->string('email');
            $table->string('phone')->nullable(); 
            $table->integer('guests'); 
            $table->dateTime('reservation_datetime'); 
            $table->text('special_requests')->nullable(); 
            $table->decimal('total_amount', 10, 2)->default(0.00);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}