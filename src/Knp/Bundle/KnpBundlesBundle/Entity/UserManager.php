<?php

namespace Knp\Bundle\KnpBundlesBundle\Entity;

use Doctrine\ORM\EntityManager;

use Symfony\Component\Console\Output\NullOutput;

use Knp\Bundle\KnpBundlesBundle\Updater\Exception\UserNotFoundException;
use Knp\Bundle\KnpBundlesBundle\Github;

/**
* 
*/
class UserManager
{
    /**
     * @var Doctrine\ORM\EntityManager
     **/
    private $entityManager;

    /**
     * @var array
     */
    private $users;


    private $repository;
    
    /**
     * @var Knp\Bundle\KnpBundlesBundle\Github\User
     */
    private $githubUserApi;

    public function __construct(EntityManager $entityManager)
    {
        $this->users = array();
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('Knp\Bundle\KnpBundlesBundle\Entity\User');
        $this->githubUserApi = new Github\User(new \Github_Client(), new NullOutput());
    }

    public function getOrCreate($username)
    {
        if (!$user = $this->repository->findOneBy(array('name' => $username))) {
            if (!$user = $this->githubUserApi->import($username)) {

                throw new UserNotFoundException();
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        return $user;
    }
}