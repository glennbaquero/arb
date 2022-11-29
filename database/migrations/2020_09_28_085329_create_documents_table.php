<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned()->index();
            $table->string('file_name');
            $table->string('file_type');
            $table->string('file_path');
            $table->integer('status')->default(0); // 0 - pending, 1 - approved, 2 - rejected
            $table->integer('supervisor_approval_status')->default(0); // 0 - pending, 1 - approved, 2 - rejected
            $table->integer('admin_approval_status')->default(0); // 0 - pending, 1 - approved, 2 - rejected
            $table->text('reject_message')->nullable();
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
        Schema::dropIfExists('documents');
    }
}
