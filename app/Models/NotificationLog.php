<?php

namespace App\Models;

use App\Enums\NotificationLog\NotificationLogChannel;
use App\Enums\NotificationLog\NotificationLogStatusStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'channel',
        'notifiable_id',
        'sender_id',
        'receiver_name',
        'receiver_email',
        'receiver_phone',
        'subject',
        'message',
        'status',
    ];

    protected $casts = [
        'channel' => NotificationLogChannel::class,
        'status' => NotificationLogStatusStatus::class,
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }

    public function receiver()
    {
        return $this->morphTo();
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
