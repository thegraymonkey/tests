<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublishersTable extends Migration
{
    public function up()
    {
        Schema::create('publishers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamps();
            $table->boolean('approved')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('publishers');
    }
}
