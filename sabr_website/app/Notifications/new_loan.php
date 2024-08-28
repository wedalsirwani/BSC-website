<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class new_loan extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $name , $user , $loan_id , $sponsor;
    public function __construct($name , $user , $loan_id,$sponsor)
    {
        $this->name=$name;
        $this->user=$user;
        $this->loan_id=$loan_id;
        $this->sponsor=$sponsor;
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
        return (new MailMessage)->subject('تم طلب قرض جديد')->view(
            'email.new_loan', ['user' => $this->user , 'name' => $this->name , 'loan_id' => $this->loan_id , 'sponsor'=>$this->sponsor ]
        );
    }

    public function toDatabase($notifiable){
        return [
            'user'=>$this->user,
            'loan_id'=>$this->loan_id
        ];
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
