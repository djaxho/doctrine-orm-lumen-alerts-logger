<?php

namespace Emporium\Svc\Alert\Model\Report;

class Report
{
    public $id;
    public $name;
    public $query;
    public $created_at;

    public function __construct($name, $query) {
        $this->name = $name;
        $this->query = $query;
        $this->created_at = new \DateTime();
    }
}
