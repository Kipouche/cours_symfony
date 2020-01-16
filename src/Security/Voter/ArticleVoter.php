<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class ArticleVoter extends Voter
{
    public function __construct(AccessDecisionManagerInterface $decisionManager){
        $this->decisionManager = $decisionManager;
    }


    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['ROLE_UPDATE_ARTICLE'])
            && $subject instanceof \App\Entity\Article;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'ROLE_UPDATE_ARTICLE':

                if($this->decisionManager->decide($token, ["ROLE_ADMIN"])){
                    return true;
                }

                return $user === $subject->getAuthor();
        }

        return false;
    }
}
