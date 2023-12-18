<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mail
{

  public function __construct(
    private MailerInterface $mailer,
  ) {
  }

  public function sendMail($from, $to, $subject, $message)
  {
    $email = (new Email())
      ->from($from)
      ->to($to)
      ->subject($subject)
      ->text($message);

    $this->mailer->send($email);
  }
}
