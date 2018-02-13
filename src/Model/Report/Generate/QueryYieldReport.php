<?php

namespace Emporium\Svc\Alert\Model\Report\Generate;

use Doctrine\ORM\EntityManagerInterface;
use Emporium\Svc\Alert\Model\{Alert, Report\Report};
use Krak\AQL;
use iter;

use function Krak\DoctrineUtil\{repoChunk, repoIter};

class QueryYieldReport implements YieldReport
{
    private $em;
    public $aql_engine;
    
    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->aql_engine = Alert\AlertSearch::createEngine();
    }

    private function getQuery(string $query)
    {
        $dql = "SELECT alert FROM Alert:Alert\Alert alert";

        if ($query) {
            $dql .= ' WHERE ' . $this->aql_engine->process($query);
        }

        $dql .= ' ORDER BY alert.id DESC';

        return $this->em->createQuery($dql);
    }

    public function yieldReport(Report $report)
    { 
        $query = $this->getQuery($report->query);

        $alerts = repoIter($query, 100);        

        yield ['Id', 'Message', 'Category', 'Severity', 'Created', 'Processed', 'Payload 1', 'Payload 2', 'Payload 3', 'Payload 4', 'Payload 5'];
        foreach ($alerts as $alert) {

            $payload_cols = iter\reduce(function($acc, $v, $k) {
                $acc[] = $k . ' - ' . $v;
                return $acc;
            }, $alert->payload, []);
            $payload_cols = array_pad($payload_cols, 5, '');

            yield array_merge(
                [
                    $alert->id,
                    $alert->msg,
                    $alert->category,
                    (string) $alert->severity,
                    ($alert->created_at instanceof \Datetime) ? $alert->created_at->format('F j, Y') : '',
                    ($alert->processed_at instanceof \Datetime) ? $alert->processed_at->format('F j, Y') : ''
                ],
                $payload_cols
            );
        }
    }
}