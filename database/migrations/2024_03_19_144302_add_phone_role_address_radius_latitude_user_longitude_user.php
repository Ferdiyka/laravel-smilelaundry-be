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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->after('email')->nullable();
            $table->string('roles')->after('phone')->nullable();
            $table->text('address')->after('roles')->nullable();
            $table->integer('radius')->after('address')->nullable();
            $table->double('latitude_user')->after('radius')->nullable();
            $table->double('longitude_user')->after('latitude_user')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'roles', 'address', 'radius', 'longitude_user', 'latitude_user']);
        });
    }
};
