<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('activity_logs', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('user_id')->nullable()->index();
      $table->string('user_name')->nullable();
      $table->string('role')->nullable();
      $table->string('action');
      $table->text('details')->nullable();
      $table->string('status')->default('success');
      $table->timestamps();

      $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
    });
  }

  public function down()
  {
    Schema::dropIfExists('activity_logs');
  }
};
