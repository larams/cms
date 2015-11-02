<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaramsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('structure_items', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('type_id')->nullable();
            $table->char('name');
            $table->char('uri');
            $table->timestamp('date');
            $table->unsignedInteger('level');
            $table->integer('left');
            $table->integer('right');
            $table->tinyInteger('active')->default(0);
            $table->tinyInteger('tree')->default(0);
            $table->text('data');
            $table->timestamps();
        });

        Schema::create('structure_types', function (Blueprint $table) {

            $table->increments('id');
            $table->char('name');
            $table->char('handler');
            $table->char('name_lang');
            $table->timestamps();

        });

        Schema::create('structure_types_relations', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('type_id');
            $table->unsignedInteger('rel_type_id');
            $table->tinyInteger('additional')->default(0);

        });

        Schema::create('users', function (Blueprint $table) {

            $table->increments('id');
            $table->char('email');
            $table->char('password');
            $table->char('name');
            $table->timestamp('logged_at');
            $table->char('last_ip');
            $table->enum('type', ['DEV', 'ADMIN'])->default('ADMIN');
            $table->char('remember_token');
            $table->timestamps();
        });

        Schema::create('translations', function( Blueprint $table ) {

            $table->increments('id');
            $table->unsignedInteger('item_id');
            $table->char('keyword');
            $table->text('value');
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
        Schema::drop( ['structure_items', 'structure_types', 'structure_types_relations', 'users', 'translations']);
    }
}