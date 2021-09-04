<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriberWebsiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriber_website', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('website_id')->unsigned();
            $table->foreign('website_id')
                    ->references('id')->on('websites')->onDelete('cascade');
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
        Schema::dropIfExists('website_subscribers');
    }
}
