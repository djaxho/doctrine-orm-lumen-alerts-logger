<?php

namespace Emporium\Svc\Alert\Model\Alert;

use Doctrine\ORM\EntityManagerInterface,
    Emporium\Svc\Alert\Model\PagedResult,
    Krak\AQL;

class AlertSearch
{
    private $em;
    private $engine;

    public function __construct(EntityManagerInterface $em, AQL\Engine $engine = null) {
        $this->em = $em;
        $this->engine = $engine ?: self::createEngine();
    }

    public function searchAlerts($q, $page = 1, $per_page = 100) {
        $dql = "SELECT alert FROM Alert:Alert\Alert alert";

        if ($q) {
            $dql .= ' WHERE ' . $this->engine->process($q);
        }

        $dql .= ' ORDER BY alert.created_at DESC';

        $query = $this->em->createQuery($dql);
        return PagedResult::createFromPaginationQuery($query, $page, $per_page);
    }

    public static function createEngine() {
        $sa = new AQL\SA\SemanticAnalysis([
            new AQL\SA\EnforceSimpleExpressions(),
            new AQL\SA\EnforceDomain([
                'alert' => ['category', 'created_at', 'severity', 'payload']
            ])
        ]);
        $visitor = new AQL\Visitor\DoubleToSingleQuotesVisitor();

        return new AQL\Engine(null, $sa, null, $visitor);
    }
}
