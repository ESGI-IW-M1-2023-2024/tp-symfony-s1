<?php

namespace App\Form\EventListener;

use App\Service\FileUploader;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class TransformFileUploadedListener implements EventSubscriberInterface
{

  public function __construct(
    private FileUploader $fileUploader
  ) {
  }

  public static function getSubscribedEvents()
  {
    return [
      FormEvents::PRE_SUBMIT => 'transformFile',
    ];
  }

  public function transformFile(FormEvent $event)
  {
    $ressource = $event->getData();
    $form = $event->getForm();
    $file = $ressource['contenu'];
    $fileName = $file ? $this->fileUploader->upload($file) : null;
    if ($fileName) {
      $form->get('contenu')->setData($fileName);
    }
  }
}
