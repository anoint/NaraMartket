<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class ListChange extends Notification
{
    use Queueable;

    public $info;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($info)
    {
        //
        $this->info = $info;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $msg =  (new MailMessage)
                    ->subject('나라장터 공고 알림')
                    ->line('새로운 공고가 생겼습니다. 확인하세요');
                    
                $msg->line(new HtmlString('공고 URL : <a target="_blank" href="'.$this->info["url"].'">바로가기</a><br>'));
                $msg->line(new HtmlString('공고파일 URL : <a target="_blank" href="'.$this->info["file1"].'">링크1</a><br>'));
                $msg->line(new HtmlString('규격서파일 URL : <a target="_blank" href="'.$this->info["file2"].'">링크2</a><br>'));
        return $msg;
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
}
