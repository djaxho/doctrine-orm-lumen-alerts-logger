<?php

namespace Emporium\Svc\Alert\Model\Subscription;

use Emporium\Svc\Alert\Model\{Subscriber};

class Subscription
{
    public $id;
    public $subscriber;
    public $category;
    public $severity;
    public $created_at;

    public function __construct(Subscriber\Subscriber $subscriber, $category, $severity) {
        $this->subscriber = $subscriber;
        $this->category = $category;
        $this->severity = $severity;
        $this->created_at = new \DateTime();
    }
}
