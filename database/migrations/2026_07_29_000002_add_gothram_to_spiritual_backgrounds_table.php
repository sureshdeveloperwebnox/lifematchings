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
        Schema::table('spiritual_backgrounds', function (Blueprint $table) {
            $table->string('gothram', 255)->nullable()->after('sub_caste_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spiritual_backgrounds', function (Blueprint $table) {
            $table->dropColumn('gothram');
        });
    }
};
