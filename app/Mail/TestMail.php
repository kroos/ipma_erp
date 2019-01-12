<?php

namespace App\Mail;

// load model
use App\Model\Staff;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestMail extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * The Staff instance.
	 *
	 * @var Staff
	 * @var Request
	 */
	public $request;
	// protected $staff;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// $this->staff = $staff;
		// $this->request = $request;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this
			->from('ipma@ipmaindustry.com', 'Miss Angeline')
			->subject('Test Subject')
			->markdown('mailer.test')
			// ->view('mailer.test')
			// ->text('mailer.test_plain')
			// ->attach('/path/to/file', [
			// 							'as' => 'name.pdf',
			// 							'mime' => 'application/pdf',
			// 						])
			;
	}
}
// mailer env
# MAIL_DRIVER=smtp
# MAIL_HOST=business29.web-hosting.com
# MAIL_PORT=465
# MAIL_USERNAME=admin@ipmaindustry.com
# MAIL_PASSWORD=ipma8799.
# MAIL_ENCRYPTION=ssl