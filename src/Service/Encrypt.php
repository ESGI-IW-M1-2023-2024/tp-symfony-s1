<?php

namespace App\Service;

use App\Entity\Lyceen;
use Doctrine\ORM\EntityManagerInterface;

class Encrypt
{

  public function __construct(
    private EntityManagerInterface $em,
  ) {
  }

  public function encryptUserPersonalData($user)
  {
    $user->setEmail(crypt($user->getEmail(), CRYPT_SHA512));
    $user->setTelephone(crypt($user->getTelephone(), CRYPT_SHA512));
    $this->em->flush();
  }

  public function encryptStudentPersonalData(Lyceen $student)
  {
    $student->setEmail(crypt($student->getEmail(), CRYPT_SHA512));
    $student->setTelephone(crypt($student->getTelephone(), CRYPT_SHA512));
    $this->em->flush();
  }

  public function encryptAllStudentsPersonalData()
  {
    $students = $this->em->getRepository(Lyceen::class)->findAll();
    foreach ($students as $student) {
      $this->encryptStudentPersonalData($student);
    }
  }
}
