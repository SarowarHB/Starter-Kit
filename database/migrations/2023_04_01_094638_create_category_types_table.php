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

        Schema::create('category_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('unique_key', 255)->unique();
            $table->boolean('is_active')->default(true);
            $table->enum('entry_type', array_keys(Enum::getCategoryEntryType()))->comment('BULK/INDIVIDUAL');
            $table->unsignedBigInteger('operator_id');

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
        Schema::dropIfExists('category_types');
    }
};
