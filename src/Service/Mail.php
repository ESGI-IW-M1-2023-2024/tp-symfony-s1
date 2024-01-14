<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mail
{

  public function __construct(
    private MailerInterface $mailer,
    private string $from,
  ) {
  }

  public function sendMail($from, $to, $subject, $template, $context): void
  {
    $email = (new TemplatedEmail())
      ->from($from)
      ->to($to)
      ->subject($subject)
      ->htmlTemplate($template)
      ->context($context);

    $this->mailer->send($email);
  }

  public function sendMailAfterRegistration($to, $context): void
  {
    $this->sendMail(
      $this->from,
      $to,
      'Inscription au forum des métiers',
      'emails/after_registration.html.twig',
      $context
    );
  }
}
