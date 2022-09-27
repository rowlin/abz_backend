<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('positions') && Schema::hasTable('users') ){
            Schema::table('users', function(Blueprint $table){
                $table->foreign('position_id')->references('id')->on('positions');
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        if(Schema::hasColumn('users' , 'position_id')) {
            Schema::table('users', function (Blueprint $table){
                $table->dropForeign('users_position_id_foreign');
            });
        }

    }
};
