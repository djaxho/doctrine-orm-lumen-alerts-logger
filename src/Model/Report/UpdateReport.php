<?php

namespace Emporium\Svc\Alert\Model\Report;

use Doctrine\ORM\EntityManagerInterface;

class UpdateReport
{
    private $em;
    private $validate_report;

    public function __construct(EntityManagerInterface $em, ValidateReport $validate_report) {
        $this->em = $em;
        $this->validate_report = $validate_report;
    }

    /**
     * Update a report
     * Cannot update name, as this might overlap an existing report's name
     * @param  [type] $report_id         [description]
     * @param  [type] $report_criteria [description]
     * @return [type]                        [description]
     */
    public function updateReportFromArray($report_id, $report_data) 
    {
        // Default value
        $report = $this->em->find('Alert:Report\Report', $report_id);

        if (! $report) {
            abort(404, 'Invalid report'); 
        }

        $this->validate_report->validateReportQuery($report_data['query']);

        $report->query = $report_data['query'];

        $this->em->persist($report);
        $this->em->flush();

        return $report;
    }
}
