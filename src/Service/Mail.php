<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mail
{

  public function __construct(
    private MailerInterface $mailer,
    private string $from,
  ) {
  }

  public function sendMail($from, $to, $subject, $template, $context)
  {
    $email = (new Email())
      ->from($from)
      ->to($to)
      ->subject($subject)
      ->htmlTemplate($template)
      ->context($context);

    $this->mailer->send($email);
  }

  public function sendMailAfterRegistration($to, $context)
  {
    return $this->sendMail(
      $this->from,
      $to,
      'Inscription au forum des métiers',
      'emails/registration.html.twig',
      $context
    );
  }
}
