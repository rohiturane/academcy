<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('student_id');
            $table->string('order_no');
            $table->unsignedBigInteger('coupon_id');
            $table->text('remark');
            $table->string('payment_mode');
            $table->double('subtotal');
            $table->double('tax');
            $table->double('total');
            $table->double('discount');
            $table->boolean('status');
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('coupon_id')->references('id')->on('coupons');
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
        Schema::dropIfExists('transactions');
    }
}
