<?php

namespace Emporium\Svc\Alert\Job;

use Emporium\Svc\Alert;

class ProcessAlertJob extends AbstractJob
{
    private $param;

    public function __construct($param) {
        $this->param = $param;
    }

    public function handle() {
        $app = Alert\app();
        $logger = $app->make('Psr\Log\LoggerInterface');
        $logger->info("Storing Job! {param}", [
            'param' => $this->param,
        ]);
    }
}
