<?php

namespace Emporium\Svc\Alert\Model\Alert;

class Alert
{
    public $id;
    public $msg;
    public $category;
    public $severity;
    public $payload;
    public $created_at;
    public $processed_at;

    public function __construct($msg, $category, $severity, array $payload = []) {
        $this->msg = $msg;
        $this->category = $category;
        $this->severity = $severity;
        $this->payload = $payload;
        $this->created_at = new \DateTime();
    }

    public function process()
    {
        $this->processed_at = new \DateTime();
    }
}
