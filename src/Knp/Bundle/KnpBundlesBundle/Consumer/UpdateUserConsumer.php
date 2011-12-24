<?php

namespace Knp\Bundle\KnpBundlesBundle\Consumer;

use Knp\Bundle\KnpBundlesBundle\Entity\UserManager;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;

use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Doctrine\ORM\EntityManager;

/**
* 
*/
class UpdateUserConsumer implements ConsumerInterface
{

    /**
     * @var Symfony\Component\HttpKernel\Log\LoggerInterface
     */ 
    private $logger;

    /**
     * @var Knp\Bundle\KnpBundlesBundle\Entity\UserManager
     */
    private $users;

    /**
     * @var Doctrine\ORM\EntityManager
     */
    private $em;

    public function __construct(EntityManager $em, UserManager $users)
    {
        $this->users = $users;
        $this->em = $em;
    }

    /**
     * Set a logger instance
     *
     * @param Symfony\Component\HttpKernel\Log\LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /** 
     * Only here because ConsumerInterface extends ContainerAwareInterface
     * @todo remove it once this PR is merged : https://github.com/videlalvaro/RabbitMqBundle/pull/13 
     */
    public function setContainer(ContainerInterface $container = null)
    {
    }

    /**
     * Callback called from RabbitMQ to update a bundle
     *
     * @param string serialized Message
     */
    public function execute($msg)
    {
    }
}