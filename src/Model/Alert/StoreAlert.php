<?php

namespace Emporium\Svc\Alert\Model\Alert;

use Doctrine\ORM\EntityManagerInterface;

class StoreAlert
{
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function storeAlertFromArray($data) {
        $alert = new Alert(
            $data['msg'],
            $data['category'],
            $data['severity'],
            $data['payload']
        );

        $this->em->persist($alert);
        $this->em->flush();

        return $alert;
    }
}
