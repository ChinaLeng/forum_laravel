<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Replie;

class TopicReplied extends Notification
{
    use Queueable;
    public $replie;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Replie $replie)
    {
                // 注入回复实体，方便 toDatabase 方法中的使用
        $this->replie = $replie;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
                // 开启通知的频道
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
/*    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }*/
    public function toMail($notifiable)
    {
        $url = $this->replie->topic->link(['#reply' . $this->replie->id]);

        return (new MailMessage)
                    ->line('你的话题有新回复！')
                    ->action('查看回复', $url);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
    public function toDatabase($notifiable)
    {
        $topic = $this->replie->topic;
        $link =  $topic->link(['#reply' . $this->replie->id]);

        // 存入数据库里的数据
        return [
            'reply_id' => $this->replie->id,
            'reply_content' => $this->replie->content,
            'user_id' => $this->replie->user->id,
            'user_name' => $this->replie->user->name,
            'user_avatar' => $this->replie->user->avatar,
            'topic_link' => $link,
            'topic_id' => $topic->id,
            'topic_title' => $topic->title,
        ];
    }
}
