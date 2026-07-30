<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalSubCasteAndAboutPartnerToPartnerExpectationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partner_expectations', function (Blueprint $table) {
            if (!Schema::hasColumn('partner_expectations', 'additional_sub_caste')) {
                $table->string('additional_sub_caste', 255)->nullable()->after('sub_caste_id');
            }
            if (!Schema::hasColumn('partner_expectations', 'about_partner')) {
                $table->text('about_partner')->nullable()->after('manglik');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partner_expectations', function (Blueprint $table) {
            if (Schema::hasColumn('partner_expectations', 'additional_sub_caste')) {
                $table->dropColumn('additional_sub_caste');
            }
            if (Schema::hasColumn('partner_expectations', 'about_partner')) {
                $table->dropColumn('about_partner');
            }
        });
    }
}
