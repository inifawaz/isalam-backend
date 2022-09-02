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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('project_id')->constrained('projects')->restrictOnDelete();
            $table->string('merchant_code');
            $table->string('merchant_order_id');
            $table->string('reference');
            $table->string('payment_url');
            $table->integer('project_amount_given');
            $table->integer('maintenance_fee');
            $table->integer('payment_fee');
            $table->integer('amount');
            $table->string('va_number');
            $table->string('payment_method');
            $table->string('payment_method_name');
            $table->string('payment_image');
            $table->string('expiry_period');


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
        Schema::dropIfExists('payments');
    }
};
