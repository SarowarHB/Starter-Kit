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

        Schema::create('stock_testings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_id');
            $table->date('testing_date');
            $table->date('next_testing_date');
            $table->enum('status', array_keys(Enum::getStockStatus()))->comment('GOOD/PROBLEM ETC');
            $table->unsignedBigInteger('operator_id');
            $table->text('note');

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
        Schema::dropIfExists('stock_testings');
    }
};
