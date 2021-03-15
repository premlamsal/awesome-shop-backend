<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            
            $table->id();
            
            $table->string('name');
            
            $table->string('custom_book_id')->nullable();
            
            $table->text('slug');
            
            $table->decimal('price');
            
            $table->decimal('quantity');
            
            $table->decimal('discount');
            
            $table->text('image');
            
            $table->text('thumb');
            
            $table->text('description');
            
            $table->text('more_info')->nullable();

            $table->text('location')->nullable();

            $table->text('highlights')->nullable();

            $table->text('deliver_locations')->nullable();

            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

          
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
        Schema::dropIfExists('books');
    }
}
