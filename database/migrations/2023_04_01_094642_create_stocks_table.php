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

        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('supplier_id');
            $table->text('note')->nullable();
            $table->string('unique_id')->unique()->nullable();
            $table->float('unit_price');
            $table->integer('quantity');
            $table->string('mac_id', 255)->comment('MAC/IME/SN')->nullable();
            $table->date('purchase_date');
            $table->date('warranty_date')->nullable();
            $table->date('testing_date')->nullable();
            $table->enum('status', array_keys(Enum::getStockStatus()))->default(Enum::STOCK_AVAILABLE)->comment('AVAILABLE, ASSIGNED, WARRANTY, DAMAGED, MISSING, EXPIRED');
            $table->string('location', 255);
            $table->unsignedBigInteger('operator_id');

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
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
        Schema::dropIfExists('stocks');
    }
};
