<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use CArbon\Carbon;

class new_transaction extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $user,$name;
    public $transaction_id;
    public function __construct($user , $name , $transaction_id)
    {
        $this->user=$user;
        $this->name=$name;
        $this->transaction_id=$transaction_id;
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
        return (new MailMessage)->subject('تم تسجيل دفعة جديدة')->view(
            'email.new_transaction', ['user' => $this->user , 'name' => $this->name , 'id' => $this->transaction_id ]
        );
    }
    public function toDatabase($notifiable){
        return [
            'user'=>$this->user,
            'transaction_id'=>$this->transaction_id
        ];
    }
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'user'=>$this->user,
            'transaction_id'=>$this->transaction_id
        ]);
    }
    public function broadcastType()
    {
        return 'new_transaction';
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
