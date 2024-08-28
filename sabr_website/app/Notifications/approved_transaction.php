<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class approved_transaction extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $user , $transaction_id , $approved;
    public function __construct($user,$transaction_id,$approved)
    {
        $this->user=$user;
        $this->transaction_id=$transaction_id;
        $this->approved=$approved;
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
        $str='رفض';
        if($this->approved){
            $str='اعتماد';
        }
        return (new MailMessage)->subject('تم '.$str.' دفعتك')->view(
            'email.transaction_approved', ['user' => $this->user , 'id' => $this->transaction_id , 'str' => $str ]
        );
    }
    public function toDatabase($notifiable){
        return [
            'user'=>$this->user,
            'transaction_id'=>$this->transaction_id
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
