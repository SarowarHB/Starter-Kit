<?php

use App\Library\Enum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('org_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('full_name');
            $table->unsignedBigInteger('assign_to_id')->nullable();
            $table->unsignedBigInteger('assign_id')->nullable();
            $table->string('subject');
            $table->longText('message');
            $table->string('attachment')->nullable();
            $table->string('department');
            $table->enum('status',  array_keys(Enum::getTicketStatus()))->default(Enum::TICKET_STATUS_OPEN);
            $table->enum('priority',  array_keys(Enum::getTicketPriority()));
            $table->unsignedBigInteger('created_by');

            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
