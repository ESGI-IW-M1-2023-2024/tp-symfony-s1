<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class Encrypt
{

  public function __construct(
    private EntityManagerInterface $em,
  ) {
  }

  public function encryptPersonnalData($user)
  {
    $user->setEmail(crypt($user->getEmail(), CRYPT_MD5));
    $user->setTelephone(crypt($user->getTelephone(), CRYPT_MD5));
    $this->em->persist($user);
    $this->em->flush();
  }
}
