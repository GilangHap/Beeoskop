<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tikets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_tayang_id')->constrained('jadwal_tayangs')->onDelete('cascade');
            $table->foreignId('kursi_id')->constrained('kursis')->onDelete('cascade');
            $table->decimal('price', 10, 2)->unsigned();
            $table->enum('ticket_status', ['Available', 'Sold', 'Unavailable'])->default('Available');
            $table->foreignId('transaksi_id')->nullable()->constrained('transaksis')->onDelete('set null');
            $table->timestamps();

            // Ensure each seat is only booked once per schedule
            $table->unique(['jadwal_tayang_id', 'kursi_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};
