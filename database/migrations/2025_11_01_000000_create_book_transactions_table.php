<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('book_transactions', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('user_id')->index();
      $table->unsignedBigInteger('book_id')->index();
      $table->timestamp('borrowed_at')->nullable();
      $table->date('due_date')->nullable();
      $table->timestamp('returned_at')->nullable();
      $table->string('status')->default('borrowed');
      $table->integer('days_overdue')->default(0);
      $table->decimal('fee', 10, 2)->default(0);
      $table->timestamps();

      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
    });
  }

  public function down()
  {
    Schema::dropIfExists('book_transactions');
  }
};
