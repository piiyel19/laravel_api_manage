<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodosMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todos_masters', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('about');
            $table->string('project_id');
            $table->string('uid');
            $table->tinyInteger('achieve')->default('0');
            $table->string('todo_pid');
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
        Schema::dropIfExists('todos_masters');
    }
}
