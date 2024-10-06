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

        Schema::create('stock_assigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('stock_id');
            $table->integer('quantity');
            $table->date('assigned_date');
            $table->enum('status', array_keys(Enum::getStockStatus()))->comment('AVAILABLE,  ASSIGNED,WARRANTY, DAMAGED, MISSION, RETURNED, EXPIRED');
            $table->boolean('acknowledgement_status')->default(0);
            $table->unsignedBigInteger('operator_id');
            $table->dateTime('received_at')->nullable();
            $table->unsignedBigInteger('received_by')->nullable();
            $table->text('note')->nullable();
            
            $table->foreign('stock_id')->references('id')->on('stocks');
            $table->foreign('operator_id')->references('id')->on('users');
            $table->foreign('received_by')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_assigns');
    }
};
