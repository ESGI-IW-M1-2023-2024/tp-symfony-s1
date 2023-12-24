<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
  public function __construct(
    private string $targetDirectory,
    private SluggerInterface $slugger,
  ) {
  }

  public function upload(UploadedFile $file, $path = null): string
  {
    $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    $safeFilename = $this->slugger->slug($originalFilename);
    $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

    if (!file_exists($this->getTargetDirectory())) {
      mkdir($this->getTargetDirectory(), 0777, true);
    }

    if (!file_exists($this->getTargetDirectory() . '/' . $path)) {
      try {
        $file->move($this->getTargetDirectory(), $fileName);
      } catch (FileException $e) {
        return false;
      }
    }


    return $fileName;
  }

  public function getTargetDirectory(): string
  {
    return $this->targetDirectory;
  }
}
