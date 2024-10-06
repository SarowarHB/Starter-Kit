<?php

use App\Library\Enum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('stock_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_id');
            $table->unsignedBigInteger('assign_id')->nullable();
            $table->integer('quantity');
            $table->enum('status', array_keys(Enum::getStockStatus()))->comment('AVAILABLE,  ASSIGNED,WARRANTY, DAMAGED, MISSION, RETURNED, EXPIRED');
            $table->date('date');
            $table->string('location', 255);
            $table->unsignedBigInteger('operator_id');
            $table->text('note')->nullable();

            $table->foreign('assign_id')->references('id')->on('stock_assigns');
            $table->foreign('stock_id')->references('id')->on('stocks');
            $table->foreign('operator_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_histories');
    }
};
