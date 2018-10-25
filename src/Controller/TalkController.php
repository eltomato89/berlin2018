<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\TalkRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route(path="/api/talks")
 */
class TalkController extends AbstractController
{
    /**
     * @Route(name="talk_list")
     */
    public function list(TalkRepository $repository, SerializerInterface $serializer)
    {
        return $repository->all();
    }

    /**
     * @Route(path="/{id}", name="talk_get")
     */
    public function getTalk(string $id, TalkRepository $repository, SerializerInterface $serializer)
    {
        $talk = $repository->get($id);

        if (null === $talk) {
            throw new NotFoundHttpException('Talk does not exist');
        }

        return $talk;
    }
}
