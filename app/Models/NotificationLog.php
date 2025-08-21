<?php

namespace App\Models;

use App\Enums\NotificationLog\NotificationLogChannel;
use App\Enums\NotificationLog\NotificationLogStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    use HasFactory;

    protected $table = 'notification_logs';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'channel',
        'notifiable_id',
        'notifiable_type',
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
        'status' => NotificationLogStatus::class,
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
