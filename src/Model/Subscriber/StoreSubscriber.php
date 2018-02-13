<?php

namespace Emporium\Svc\Alert\Model\Subscriber;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class StoreSubscriber
{
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function storeSubscriberFromArray($data) {
        $subscriber = new Subscriber(
            $data['email'],
            $data['name']
        );

        $this->em->persist($subscriber);
        $this->em->flush();

        return $subscriber;
    }
}
