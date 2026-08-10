<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Member;
use App\Models\User;
use App\Utility\EmailUtility;

class CheckPackageExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:check-package-expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check member package validity and send expiration notification emails to member and admin.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = date('Y-m-d');

        // Find members whose package validity has passed and have not been notified yet
        $expiredMembers = Member::whereNotNull('package_validity')
            ->where('package_validity', '<', $today)
            ->where(function($query) {
                $query->where('expiry_notified', 0)
                      ->orWhereNull('expiry_notified');
            })
            ->get();

        $admins = User::where('user_type', 'admin')->get();

        foreach ($expiredMembers as $member) {
            $user = $member->user;
            if ($user) {
                // Send email to user
                EmailUtility::package_expired_user_email($user);

                // In-app notification for user
                \App\Utility\NotificationUtility::set_notification(
                    'package_expired',
                    'Your subscription package has expired. Please renew to access all features.',
                    route('packages.index'),
                    $user->id,
                    $user->id,
                    'member'
                );

                // Send email & in-app notification to admins
                foreach ($admins as $admin) {
                    EmailUtility::package_expired_admin_email($user, $admin);

                    \App\Utility\NotificationUtility::set_notification(
                        'package_expired_admin',
                        'Package expired for member: ' . $user->first_name . ' ' . $user->last_name,
                        route('members.show', $user->id),
                        $user->id,
                        $admin->id,
                        'admin'
                    );
                }
            }

            // Mark member as notified
            $member->expiry_notified = 1;
            $member->save();
        }

        $this->info('Checked package expirations: ' . count($expiredMembers) . ' members processed.');

        return 0;
    }
}
