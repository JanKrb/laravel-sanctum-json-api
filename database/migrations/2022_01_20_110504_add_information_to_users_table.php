<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInformationToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add first & last name
            $table->string('first_name')
                ->after('name')
                ->nullable();
            $table->string('last_name')
                ->after('first_name')
                ->nullable();

            // Add phone number
            $table->string('phone')
                ->after('email')
                ->nullable();

            // Add birthdate
            $table->date('birthdate')
                ->after('phone')
                ->nullable();

            // Add profile picture
            $table->string('profile_picture')
                ->after('last_name')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove first & last name
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');

            // Remove phone number
            $table->dropColumn('phone');

            // Remove birthdate
            $table->dropColumn('birthdate');

            // Remove profile picture
            $table->dropColumn('profile_picture');
        });
    }
}
