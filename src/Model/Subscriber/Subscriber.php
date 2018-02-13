<?php

namespace Emporium\Svc\Alert\Model\Subscriber;

class Subscriber
{
    public $id;
    public $email;
    public $name;
    public $created_at;
    public $subscriptions;

    public function __construct($email, $name) {
        $this->email = $email;
        $this->name = $name;
        $this->created_at = new \DateTime();
    }
}
