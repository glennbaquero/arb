<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSampleItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sample_items', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('sample_item_id')->nullable();

            $table->string('name');
            $table->longText('description')->nullable();

            $table->text('image_path')->nullable();

            $table->text('data')->nullable();
            $table->datetime('date')->nullable();
            $table->text('dates')->nullable();

            $table->text('reason')->nullable();

            $table->string('status')->default('PENDING');

            $table->integer('order_column')->default(0);

            $table->softDeletes();
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
        Schema::dropIfExists('sample_items');
    }
}
