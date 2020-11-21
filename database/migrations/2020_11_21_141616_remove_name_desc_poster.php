<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveNameDescPoster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('posters','name') && Schema::hasColumn('posters','description')){
            Schema::table('posters', function (Blueprint $table) {
                //
                $table->dropColumn(['name','description']);
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
        Schema::table('posters', function (Blueprint $table) {
            //
        });
    }
}
