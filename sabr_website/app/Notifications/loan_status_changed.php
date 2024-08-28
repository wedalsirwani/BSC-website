<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class loan_status_changed extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $name , $user , $loan_id , $owner , $response;
    public function __construct( $name , $user , $loan_id , $owner , $response)
    {
        $this->name=$name;
        $this->user=$user;
        $this->loan_id=$loan_id;
        $this->owner=$owner;
        $this->response=$response;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->subject("تم {$this->response} كفالة قرض")->view(
            'email.loan_status_changed', ['user' => $this->user , 'name' => $this->name , 'loan_id' => $this->loan_id , 'owner'=>$this->owner , 'response'=>$this->response ]
        );
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
