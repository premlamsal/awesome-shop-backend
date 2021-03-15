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

            $table->string('action');

            $table->string('amount');

            $table->string('ref_id')->nullable();

            $table->unsignedBigInteger('user_id');

            $table->string('custom_transaction_id');

            $table->enum('method', ['esewa', 'khalti']);

            $table->enum('status', ['pending', 'approved','success','canceled']);
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
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
