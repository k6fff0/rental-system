<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class SmartNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * محتوى الإشعار
     */
    protected string $title;
    protected string $message;
    protected string $url;
    protected string $target;   // admin | technician | tenant | broker | ...

    /**
     * أنشئ إشعار ذكي جديد.
     *
     * @param  string  $title   عنوان مختصر للإشعار
     * @param  string  $message نص الإشعار
     * @param  string  $url     رابط الانتقال (يمكن '#')
     * @param  string  $target  من يجب أن يستقبل الإشعار (role أو نوع)
     */
    public function __construct(
        string $title,
        string $message,
        string $url = '#',
        string $target = 'admin'
    ) {
        $this->title  = $title;
        $this->message = $message;
        $this->url    = $url;
        $this->target = $target;
    }

    /**
     * قنوات التوصيل.
     */
    public function via(object $notifiable): array
    {
        return ['database']; // لاحقاً ممكن تضيف broadcast, mail ...
    }

    /**
     * تمثيل البيانات المُخزَّنة في قاعدة البيانات.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title'   => $this->title,
            'message' => $this->message,
            'url'     => $this->url,
            'target'  => $this->target,
        ];
    }

    /**
     * تمثيل بديل في حالة الاستخدام كـ array.
     */
    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
