<?php

namespace App\Utility;

use App\Models\User;
use App\Notifications\DbStoreNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification as NotificationFacade;
use Illuminate\Support\Facades\Log;

class NotificationUtility
{
    /**
     * Store and dispatch an in-app database notification.
     *
     * @param string $type
     * @param string $message
     * @param string $link
     * @param int|bool $sender
     * @param int $receiver
     * @param string|null $showing_panel
     * @return void
     */
    public static function set_notification($type, $message = '', $link = '/', $sender = false, $receiver = 0, $showing_panel = null)
    {
        try {
            $receiverId = (int) $receiver;
            if ($receiverId <= 0) {
                return;
            }

            $recipient = User::find($receiverId);
            if (!$recipient) {
                return;
            }

            $notify_by = $sender ? (int) $sender : (Auth::check() ? Auth::id() : 0);
            $id = unique_notify_id();

            NotificationFacade::send(
                $recipient,
                new DbStoreNotification(
                    $type,
                    $id,
                    $notify_by,
                    $receiverId,
                    translate($message),
                    $link
                )
            );
        } catch (\Throwable $e) {
            Log::error('NotificationUtility::set_notification error: ' . $e->getMessage(), [
                'type' => $type,
                'receiver' => $receiver,
                'sender' => $sender
            ]);
        }
    }
}

