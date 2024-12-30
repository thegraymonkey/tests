<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('publisher_id')->constrained('publishers')->onDelete('cascade'); // Sets foreign key to publishers table
            $table->timestamps();
            $table->string('title');
            $table->text('description');
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
