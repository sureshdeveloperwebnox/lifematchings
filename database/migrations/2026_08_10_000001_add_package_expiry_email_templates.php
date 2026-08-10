<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use DB;

class AddPackageExpiryEmailTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('members')) {
            if (!Schema::hasColumn('members', 'expiry_notified')) {
                Schema::table('members', function (Blueprint $table) {
                    $table->tinyInteger('expiry_notified')->default(0)->after('package_validity');
                });
            }
        }

        if (Schema::hasTable('email_templates')) {
            $user_template = DB::table('email_templates')->where('identifier', 'package_expired_user_email')->first();
            if (!$user_template) {
                DB::table('email_templates')->insert([
                    'identifier' => 'package_expired_user_email',
                    'subject'    => 'Your Package Has Expired - Life Matchings',
                    'body'       => '<p>Dear [[name]],</p><p>Your subscription package (<strong>[[package_name]]</strong>) on [[site_name]] has expired on [[expiry_date]].</p><p>Please upgrade or renew your package to continue enjoying premium services.</p><p>Regards,<br>[[from]]</p>',
                    'status'     => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $admin_template = DB::table('email_templates')->where('identifier', 'package_expired_admin_email')->first();
            if (!$admin_template) {
                DB::table('email_templates')->insert([
                    'identifier' => 'package_expired_admin_email',
                    'subject'    => 'Member Package Expired Alert - [[member_name]]',
                    'body'       => '<p>Hello Admin,</p><p>The package for member <strong>[[member_name]]</strong> (Email: [[email]]) has expired on [[expiry_date]].</p><p>You can view member details here: <a href="[[profile_link]]">[[profile_link]]</a></p><p>Regards,<br>[[from]]</p>',
                    'status'     => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('members')) {
            if (Schema::hasColumn('members', 'expiry_notified')) {
                Schema::table('members', function (Blueprint $table) {
                    $table->dropColumn('expiry_notified');
                });
            }
        }

        if (Schema::hasTable('email_templates')) {
            DB::table('email_templates')->whereIn('identifier', [
                'package_expired_user_email',
                'package_expired_admin_email'
            ])->delete();
        }
    }
}
