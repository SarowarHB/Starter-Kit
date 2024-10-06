<?php

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
        Schema::create('salary_expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->comment('user.id = employee_id');
            $table->string('payment_method');
            $table->date('month_of_salary');
            $table->float('salary',10,4);
            $table->float('bonus', 10,4);
            $table->float('total_salary', 10,4);
            $table->date('trans_date');
            $table->longText('note')->nullable();
            $table->integer('status')->comment('0 = delete, 1 = insert, 2 = update')->default(1);
            $table->unsignedBigInteger('created_by');
            
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary_expenses');
    }
};
