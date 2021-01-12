<?php

namespace app\core;

class Email
{
	public function send($email, $subject, $body)
    {
		return mail($email, $subject, $body);
	}

}