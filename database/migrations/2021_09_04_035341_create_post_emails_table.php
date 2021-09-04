<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_emails', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('post_id')->unsigned();
            $table->foreign('post_id')
                    ->references('id')->on('posts')->onDelete('cascade');
            $table->bigInteger('subscriber_id')->unsigned();
            $table->foreign('subscriber_id')
                    ->references('id')->on('subscribers')->onDelete('cascade');                    
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
        Schema::dropIfExists('post_emails');
    }
}
