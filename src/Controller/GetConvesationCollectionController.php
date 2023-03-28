<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetConversationCollectionController extends AbstractController
{
    public function __invoke(): array
    {
        /** @var User $user */
        $user = $this->getUser();
        
        $ownerConversations = $user->getOwnerConversations()->getValues();
        $guestConversations = $user->getGuestConversations()->getValues();
        
        return array_merge($ownerConversations, $guestConversations);
    }
}