<?php

namespace Emporium\Svc\Alert\Model\Report;

use Doctrine\ORM\EntityManagerInterface;

class StoreReport
{
    private $em;
    private $validate_report;

    public function __construct(EntityManagerInterface $em, ValidateReport $validate_report) {
        $this->em = $em;
        $this->validate_report = $validate_report;
    }

    public function storeReportFromArray($report_data) {
        
        if ($this->em->getRepository('Alert:Report\Report')->findOneBy(array('name' => $report_data['name']))) {
            abort(422, 'Error: Report by this name already exists');
        }

        $this->validate_report->validateReportQuery($report_data['query']);

        $report = new Report(
            $report_data['name'],
            $report_data['query']
        );

        $this->em->persist($report);
        $this->em->flush();

        return $report;
    }
}
