<?php
namespace App\Utility;
use Notification;
use App\Notifications\EmailNotification;
use App\Models\Package;
use App\Models\User;
use Auth;

class EmailUtility
{
    public static function account_oppening_email($user_id = '', $pass = '')
    {
        $user           = User::where('id',$user_id)->first();
        $subject        = get_email_template('account_oppening_email','subject');
        $account_type   = $user->membership == 1 ? 'Free' : 'Premium';
        $email_body     = get_email_template('account_oppening_email','body');
        $email_body     = str_replace('[[name]]', $user->first_name.' '.$user->last_name, $email_body);
        $email_body     = str_replace('[[code]]', $user->code, $email_body);
        $email_body     = str_replace('[[sitename]]', get_setting('website_name'), $email_body);
        $email_body     = str_replace('[[account_type]]', $account_type, $email_body);
        $email_body     = str_replace('[[email]]', $user->email, $email_body);
        $email_body     = str_replace('[[password]]', $pass, $email_body);
        $email_body     = str_replace('[[url]]', env('APP_URL'), $email_body);
        $email_body     = str_replace('[[from]]', env('MAIL_FROM_NAME'), $email_body);

        try{
            Notification::send($user, new EmailNotification($subject, $email_body));
        }
        catch(\Exception $e){
            // dd($e);
        }
    }

    public static function account_opening_email_to_admin($user = '', $admin = '')
    {
        $subject = get_email_template('account_opening_email_to_admin','subject');
        $email_body = get_email_template('account_opening_email_to_admin','body');
        $email_body = str_replace('[[member_name]]', $user->first_name.' '.$user->last_name, $email_body);
        $email_body = str_replace('[[email]]', $user->email, $email_body);
        $email_body = str_replace('[[profile_link]]', env('APP_URL').'/admin/members/'.$user->id, $email_body);
        $email_body = str_replace('[[from]]', env('MAIL_FROM_NAME'), $email_body);

        try{
            Notification::send($admin, new EmailNotification($subject, $email_body));
        }
        catch(\Exception $e){
            // dd($e);
        }
    }

    public static function member_verification_email($user = '', $status)
    {
        $subject = get_email_template('member_verification_email','subject');
        $email_body = get_email_template('member_verification_email','body');
        $email_body = str_replace('[[name]]', $user->first_name.' '.$user->last_name, $email_body);
        $email_body = str_replace('[[status]]', $status, $email_body);
        $email_body = str_replace('[[from]]', env('MAIL_FROM_NAME'), $email_body);

        try{
            Notification::send($user, new EmailNotification($subject, $email_body));
        }
        catch(\Exception $e){
            // dd($e);
        }
    }

    public static function staff_account_opening_email($user = '', $pass = '', $role_name = '')
    {
        $subject    = get_email_template('staff_account_opening_email','subject');
        $email_body = get_email_template('staff_account_opening_email','body');
        $email_body = str_replace('[[name]]', $user->first_name.' '.$user->last_name, $email_body);
        $email_body = str_replace('[[site_name]]', get_setting('website_name'), $email_body);
        $email_body = str_replace('[[role_type]]', $role_name, $email_body);
        $email_body = str_replace('[[email]]', $user->email, $email_body);
        $email_body = str_replace('[[password]]', $pass, $email_body);
        $email_body = str_replace('[[url]]', env('APP_URL'), $email_body);
        $email_body = str_replace('[[from]]', env('MAIL_FROM_NAME'), $email_body);
        
        try{
            Notification::send($user, new EmailNotification($subject, $email_body));
        }
        catch(\Exception $e){
            // dd($e);
        }
    }

    public static function package_purchase_email($user = '', $package_payment = '')
    {
        $account_type = $package_payment->package_id== 1 ? 'Free' : 'Preminum';
        $package_name = Package::where('id',$package_payment->package_id)->first()->name;
        $subject    = get_email_template('package_purchase_email','subject');
        $email_body = get_email_template('package_purchase_email','body');
        $email_body = str_replace('[[name]]', $user->first_name.' '.$user->last_name, $email_body);
        $email_body = str_replace('[[site_name]]', get_setting('website_name'), $email_body);
        $email_body = str_replace('[[account_type]]', $account_type , $email_body);
        $email_body = str_replace('[[payment_code]]', $package_payment->payment_code, $email_body);
        $email_body = str_replace('[[package]]', $package_name, $email_body);
        $email_body = str_replace('[[amount]]', $package_payment->amount, $email_body);
        $email_body = str_replace('[[from]]', env('MAIL_FROM_NAME'), $email_body);

        try{
            Notification::send($user, new EmailNotification($subject, $email_body));
        }
        catch(\Exception $e){
            // dd($e);
        }
    }

    public static function manual_payment_approval_email($user = '', $package_payment = '')
    {
        $account_type = $package_payment->package_id== 1 ? 'Free' : 'Preminum';
        $package_name = Package::where('id',$package_payment->package_id)->first()->name;
        $subject    = get_email_template('manual_payment_approval_email','subject');
        $email_body = get_email_template('manual_payment_approval_email','body');
        $email_body = str_replace('[[name]]', $user->first_name.' '.$user->last_name, $email_body);
        $email_body = str_replace('[[account_type]]', $account_type , $email_body);
        $email_body = str_replace('[[payment_code]]', $package_payment->payment_code, $email_body);
        $email_body = str_replace('[[package]]', $package_name, $email_body);
        $email_body = str_replace('[[amount]]', $package_payment->amount, $email_body);
        $email_body = str_replace('[[from]]', env('MAIL_FROM_NAME'), $email_body);

        try{
            Notification::send($user, new EmailNotification($subject, $email_body));
        }
        catch(\Exception $e){
            // dd($e);
        }
    }

    public static function email_on_accepting_interest($user = '', $interest = '')
    {
        $subject    = get_email_template('email_on_accepting_interest','subject');
        $email_body = get_email_template('email_on_accepting_interest','body');
        $email_body = str_replace('[[name]]', $user->first_name.' '.$user->last_name, $email_body);
        $email_body = str_replace('[[member_name]]', $interest->user->first_name.' '.$interest->user->last_name , $email_body);
        $email_body = str_replace('[[from]]', env('MAIL_FROM_NAME'), $email_body);

        try{
            Notification::send($user, new EmailNotification($subject, $email_body));
        }
        catch(\Exception $e){
            // dd($e);
        }
    }

    public static function password_reset_email($user = '', $code = '')
    {
        $subject    = get_email_template('password_reset_email','subject');
        $email_body = get_email_template('password_reset_email','body');
        $email_body = str_replace('[[name]]', $user->first_name.' '.$user->last_name, $email_body);
        $email_body = str_replace('[[code]]', $code, $email_body);
        $email_body = str_replace('[[from]]', env('MAIL_FROM_NAME'), $email_body);

        try{
            Notification::send($user, new EmailNotification($subject, $email_body));
        }
        catch(\Exception $e){
            // dd($e);
        }
    }

    public static function email_on_request($user, $identifier)
    {   
        $auth_user  = Auth::user();
        $subject    = get_email_template($identifier,'subject');
        $email_body = get_email_template($identifier,'body');
        $email_body = str_replace('[[name]]', $user->first_name.' '.$user->last_name, $email_body);
        $email_body = str_replace('[[member_name]]', $auth_user->first_name.' '.$auth_user->last_name , $email_body);
        $email_body = str_replace('[[from]]', env('MAIL_FROM_NAME'), $email_body);
        try{
            Notification::send($user, new EmailNotification($subject, $email_body));
        }
        catch(\Exception $e){
            // dd($e);
        }
    }

    public static function email_on_accept_request($notify_user, $identifier)
    {
        $auth_user  = Auth::user();
        $subject    = get_email_template($identifier,'subject');
        $email_body = get_email_template($identifier,'body');
        $email_body = str_replace('[[name]]', $notify_user->first_name.' '.$notify_user->last_name, $email_body);
        $email_body = str_replace('[[member_name]]', $auth_user->first_name.' '. $auth_user->last_name , $email_body);
        $email_body = str_replace('[[from]]', env('MAIL_FROM_NAME'), $email_body);
        try{
            Notification::send($notify_user, new EmailNotification($subject, $email_body));
        }
        catch(\Exception $e){
            // dd($e);
        }
    }

    public static function package_expired_user_email($user = '')
    {
        if (!$user || empty($user->email)) {
            return;
        }

        $subject    = get_email_template('package_expired_user_email','subject');
        $email_body = get_email_template('package_expired_user_email','body');
        $package_name = optional(optional($user->member)->package)->name ?? 'Package';
        $expiry_date  = optional($user->member)->package_validity ?? date('Y-m-d');

        $email_body = str_replace('[[name]]', $user->first_name.' '.$user->last_name, $email_body);
        $email_body = str_replace('[[package_name]]', $package_name, $email_body);
        $email_body = str_replace('[[expiry_date]]', date('d-m-Y', strtotime($expiry_date)), $email_body);
        $email_body = str_replace('[[site_name]]', get_setting('website_name'), $email_body);
        $email_body = str_replace('[[from]]', env('MAIL_FROM_NAME'), $email_body);

        try{
            Notification::send($user, new EmailNotification($subject, $email_body));
        }
        catch(\Throwable $e){
            \Illuminate\Support\Facades\Log::error('package_expired_user_email failed: ' . $e->getMessage());
        }
    }

    public static function package_expired_admin_email($user = '', $admin = '')
    {
        if (!$admin || empty($admin->email)) {
            return;
        }

        $subject    = get_email_template('package_expired_admin_email','subject');
        $email_body = get_email_template('package_expired_admin_email','body');
        $expiry_date  = optional(optional($user)->member)->package_validity ?? date('Y-m-d');

        $email_body = str_replace('[[member_name]]', optional($user)->first_name.' '.optional($user)->last_name, $email_body);
        $email_body = str_replace('[[email]]', optional($user)->email ?? '', $email_body);
        $email_body = str_replace('[[expiry_date]]', date('d-m-Y', strtotime($expiry_date)), $email_body);
        $email_body = str_replace('[[profile_link]]', env('APP_URL').'/admin/members/'.optional($user)->id, $email_body);
        $email_body = str_replace('[[from]]', env('MAIL_FROM_NAME'), $email_body);

        try{
            Notification::send($admin, new EmailNotification($subject, $email_body));
        }
        catch(\Throwable $e){
            \Illuminate\Support\Facades\Log::error('package_expired_admin_email failed: ' . $e->getMessage());
        }
    }

}

?>

