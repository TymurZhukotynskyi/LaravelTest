<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //РАЗДЕЛИТЬ УДАЛЕНИЕ И ДОБАВЛЕНИЕ КОЛОНОК НА ТРИ (и обновление тоже) МИГРАЦИИ - ОСОБЕННОСТЬ  SQLLITE

        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->unique('username_unique')->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->unique('userphone_unique')->after('name');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'email',
                'email_verified_at',
                'password',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
//        Schema::table('users', function (Blueprint $table) {
//            $table->dropUnique('username_unique');
//        });
//
//        Schema::table('users', function (Blueprint $table) {
//            $table->dropColumn(['phone']);
//        });
//
//        Schema::table('users', function (Blueprint $table) {
//            $table->string('email')->unique()->after('name');
//            $table->timestamp('email_verified_at')->nullable()->after('email');
//            $table->string('password')->after('email_verified_at');
//        });

        Schema::dropIfExists('users');
    }
};
