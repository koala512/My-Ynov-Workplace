<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class GetThreadController extends AbstractController
{
    public function __invoke(Conversation $conversation): Conversation
    {
        /** @var User $user */
        $user = $this->getUser();
        if ( $conversation->getOwner() === $user || $conversation->getGuest() === $user) {
            return $conversation;
        } else {
            throw new AccessDeniedHttpException();
        }
    }
}