<?php

use App\Entity\Atelier;
use App\Service\FileUploader;
use Symfony\Component\Form\Test\FormInterface;

class FileResourceHandler
{
  public function __construct(
    private FileUploader $fileUploader
  ) {
  }

  public function handle(Atelier $atelier, FormInterface $form): void
  {
    $ressources = $form->get('ressources')->getData();

    foreach ($ressources as $key => $ressource) {
      $file = $form->get('ressources')->all()[$key]->all()['contenu']->getData();
      $fileName = $this->fileUploader->upload($file);
      $ressource->setContenu($fileName);
      $ressource->setAtelier($atelier);
      $atelier->addRessource($ressource);
    }
  }
}
