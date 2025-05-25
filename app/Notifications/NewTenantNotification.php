<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewTenantNotification extends Notification
{
    use Queueable;

    protected $tenantName;

    /**
     * Create a new notification instance.
     */
    public function __construct($tenantName)
    {
        $this->tenantName = $tenantName;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Store notification data in the database.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => '📢 تم تسجيل مستأجر جديد',
            'message' => 'تم تسجيل المستأجر: ' . $this->tenantName,
            'url' => url('/admin/tenants'),
        ];
    }

    /**
     * Optional: JSON format.
     */
    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
