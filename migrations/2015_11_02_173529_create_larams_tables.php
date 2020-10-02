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
            $table->char('uri')->nullable();
            $table->unsignedTinyInteger('custom_uri')->default(0);
            $table->timestamp('date');
            $table->unsignedInteger('level');
            $table->integer('left');
            $table->integer('right');
            $table->tinyInteger('active')->default(0);
            $table->tinyInteger('tree')->default(0);
            $table->text('search')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['left', 'right'], 'left_right');
            $table->index('deleted_at');
            $table->index(['parent_id', 'active']);
            $table->index('type_id');
        });

//        DB::statement('ALTER TABLE structure_items ADD FULLTEXT FULL( search )');

        Schema::create('structure_data', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('item_id')->nullable();
            $table->char('name');
            $table->text('data');
            $table->timestamps();

            $table->index('item_id');

        });

        Schema::create('structure_types', function (Blueprint $table) {

            $table->increments('id');
            $table->char('name');
            $table->char('handler');
            $table->char('name_lang');
            $table->timestamps();

            $table->index('name');

        });

        Schema::create('structure_types_relations', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('type_id');
            $table->unsignedInteger('rel_type_id');
            $table->tinyInteger('additional')->default(0);

        });

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->char('title')->nullable()->default(null);
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->char('permission')->nullable()->default(null);
            $table->char('title')->nullable()->default(null);
            $table->timestamps();
        });

        Schema::create('roles_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('permission_id');
            $table->enum('type', ['ALLOW', 'DENY'])->default('ALLOW');
            $table->timestamps();
        });

        Schema::table('roles_permissions', function( Blueprint $table ) {
            $table->foreign('role_id')->references('id')->on('roles')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('permission_id')->references('id')->on('permissions')->onUpdate('CASCADE')->onDelete('CASCADE');
        });

        Schema::create('users', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('role_id');
            $table->char('email');
            $table->char('password');
            $table->char('name');
            $table->timestamp('logged_at');
            $table->char('last_ip')->nullable();
            $table->tinyInteger('require_change')->default(0);
            $table->char('remember_token')->nullable();
            $table->timestamp('password_changed_at')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles')->onUpdate('CASCADE')->onDelete('CASCADE');
        });

        Schema::create('users_logins', function (Blueprint $table) {

            $table->increments('id');
            $table->char('username');
            $table->char('ip');
            $table->unsignedInteger('has_logged');
            $table->timestamps();

        });

        Schema::create('translation_keywords', function (Blueprint $table) {

            $table->increments('id');
            $table->text('keyword');
            $table->timestamps();

        });

        Schema::create('translation_values', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('keyword_id');
            $table->unsignedInteger('language_id');
            $table->text('value');
            $table->timestamps();
        });

        Schema::create('actions_log', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('related_id');
            $table->char('type');
            $table->char('message');
            $table->longText('data')->nullable();
            $table->timestamps();
        });

        Schema::table('structure_items', function (Blueprint $table) {
            $table->foreign('type_id')->references('id')->on('structure_types')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('parent_id')->references('id')->on('structure_items')->onUpdate('CASCADE')->onDelete('CASCADE');
        });

        Schema::table('structure_data', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('structure_items')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('structure_items');
        Schema::drop('structure_types');
        Schema::drop('structure_types_relations');
        Schema::drop('users');
        Schema::drop('roles_permissioins');
        Schema::drop('roles');
        Schema::drop('permissions');
        Schema::drop('translations');
        Schema::drop('roles');
        Schema::drop('permissions');
        Schema::drop('roles_permissions');
    }
}
