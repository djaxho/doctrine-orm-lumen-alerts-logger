<?php

namespace Emporium\Svc\Alert\Model\Report\Generate;

use Emporium\Svc\Alert\Model\Report\{Report};

class GenerateReport
{
    private $yield_report;
    private $export_report;

    public function __construct(YieldReport $yield_report, ExportReport $export_report)
    {
        $this->yield_report = $yield_report;
        $this->export_report = $export_report;
    }

    /**
     * [generateReport description]
     * @param  Report $report [description]
     * @param  string $format a ReportFormat const
     * @param  resource $dst a stream to write the report into
     * @return [type] [description]
     */
    public function generateReport(Report $report, $format, $dst) {
        
        $rows = $this->yield_report->yieldReport($report);
        return $this->export_report->exportReport($rows, $format, $dst);
    }
}
