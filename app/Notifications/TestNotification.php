<?php
namespace App\Notifications;

// https://code.tutsplus.com/tutorials/notifications-in-laravel--cms-30499
// https://laravel.com/docs/5.6/notifications#introduction

// load model
use App\Model\Staff;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TestNotification extends Notification
{
	use Queueable;

	// load staff in class
	public $staff;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(Staff $staff)
	{
		$this->staff = $staff;
	}
	
	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
	    // return ['mail'];
	    return ['database'];
	}
	
	/**
	 * Get the mail representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	// public function toMail($notifiable)
	// {
	// 	$url = url('/invoice/'.$this->invoice->id);

	// 	return (new MailMessage)
	// 			->greeting('Hello!')
	// 			->line('One of your invoices has been paid!')
	// 			->action('View Invoice', $url)
	// 			->line('Thank you for using our application!');
	// }

	// notifications being stored to database, got 2 method "toArray" and "toDatabse"
	// public function toDatabase($notifiable)
	// {
	// 	// 
	// }

	/**
	 * Get the array representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function toArray($notifiable)
	{
		return [
			'data' => 'My Notification To You',
			'from_id' => $this->staff->id,
		];
	}
}
