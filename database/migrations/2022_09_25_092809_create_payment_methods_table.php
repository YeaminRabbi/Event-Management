<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->smallIncrements('id' );
            $table->unsignedTinyInteger('type' );
            $table->unsignedTinyInteger('account_type' )->comment('1=personal, 2=merchant')->default(1);
            $table->unsignedTinyInteger('status' )->comment('1=active, 0=Inactive')->default(0);
            $table->string('account_number' );
            $table->text('instructions' )->nullable();
            $table->text('nb')->nullable();
            $table->float('charge_percentage',4,2,true )->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
}
