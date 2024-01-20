<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Photo;
use App\Repository\GuineaPigRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CreatePhotoAction extends AbstractController
{
    public function __invoke(Request $request, GuineaPigRepository $guineaPigRepository): Photo
    {
        $guineaPig = $guineaPigRepository->find($request->attributes->get('guineaPigId'));

        if (null === $guineaPig) {
            throw $this->createNotFoundException();
        }

        if ($guineaPig->getOwner() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $uploadedFile = $request->files->get('file');

        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $photo = new Photo();
        $photo->setGuineaPig($guineaPig);
        $photo->setFile($uploadedFile);

        return $photo;
    }
}

