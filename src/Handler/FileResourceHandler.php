<?php

namespace App\Handler;

use App\Entity\Atelier;
use App\Entity\Ressource;
use App\Service\FileUploader;
use Symfony\Component\Form\Form;

class FileResourceHandler
{
  public function __construct(
    private FileUploader $fileUploader,
    private string $uploadDirectory
  ) {
  }

  public function handleNew(Atelier $atelier, Form $form): void
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

  public function handleNewOne(Ressource $ressource, Atelier $atelier, $file): void
  {
    $fileName = $this->fileUploader->upload($file);
    $ressource->setContenu($fileName);
    $ressource->setAtelier($atelier);
    $atelier->addRessource($ressource);
  }

  public function handleDelete(Atelier $atelier, Form $form): void
  {
    $ressources = $atelier->getRessources();

    foreach ($ressources as $ressource) {
      if ($ressource->getContenu() !== null) {
        unlink($this->uploadDirectory . '/' . $ressource->getContenu());
      }
    }
  }

  public function handleDeleteOne(Ressource $ressource): void
  {
    if ($ressource->getContenu() !== null) {
      unlink($this->uploadDirectory . '/' . $ressource->getContenu());
    }
  }
}
