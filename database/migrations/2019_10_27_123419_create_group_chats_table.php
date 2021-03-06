<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_chats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('group_message_id');
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('from_id')->nullable();//để xác định user gửi mess
            $table->integer('type'); //0-send 1-receive 2-admin
            $table->dateTime('read_at')->nullable();
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
        Schema::dropIfExists('group_chats');
    }
}
