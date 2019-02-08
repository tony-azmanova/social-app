<?php

namespace App\Services;

use App\Friend;

/**
 * Description of FriendshipService
 *
 * @author tony
 */
class FriendshipService
{
    const STATUS_PENDING = 'pending';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_CANCEL = 'cancel';
    
    /**
     * Get the current status of friendship request for given user id
     * 
     * @param integer $receverId
     * @return boolean
     */
    public function checkFriendRequesStatus($receverId)
    {
        $status = Friend::where('recever_id', $receverId)
                ->where('sender_id', auth()->id())
                ->orWhere('sender_id', auth()->id())
                ->where('recever_id', $receverId)
                ->latest()
                ->get()->first();

        if (is_null($status)) {
            return $friendshipStatus = [
                'friendshipStatus'=> false,
                'message' => 'You are not frieds with this user!'
            ];
        }
        
        if ($status['status'] === self::STATUS_PENDING) {
            return $friendshipStatus = [
                'friendshipStatus'=> $status['status'],
                'message' => 'You are waiting for this user to accsept your friend request!'
            ];
        }

        if ($status['status'] === self::STATUS_ACCEPTED) {
            return $friendshipStatus = [
                'friendshipStatus'=> $status['status'],
                'message' => 'You are friend with this user!'
            ];
        }

        if ($status['status'] === self::STATUS_CANCEL) {
            return $friendshipStatus = [
                'friendshipStatus'=> $status['status'],
                'message' => 'Sorry your friend request was canceled, but you can send another!'
            ];
        }
    }

    /**
     * Change the notification status
     * 
     * @param string $status
     * @param type $notification
     * @return string
     */
    public function changeStatus($status, $notification)
    {
        $friendStatus = Friend::where('recever_id', $notification->notifiable_id)
            ->where('sender_id', $notification->data['sender_id'])
            ->get()
            ->first();

        if ($status !== $friendStatus['status']) {
            $friendStatus->status = $status;
            $friendStatus->save();
            $notification->markAsRead();
        }

        return $friendStatus['status'];
    }
}
