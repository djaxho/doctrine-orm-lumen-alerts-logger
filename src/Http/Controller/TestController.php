<?php 

namespace Emporium\Svc\Alert\Http\Controller;

use Emporium\Svc\Alert\Model\Report\{Report};
use Emporium\Svc\Alert\Model\Report\{Generate\GenerateReport, Generate\QueryYieldReport, Generate\BoxExportReport, Generate\ReportFormat};
use function Emporium\Svc\Alert\app;


/**
* 
*/
class TestController
{
    
    function __construct()
    {
        # code...
    }

    public function test()
    {
        $generate = new GenerateReport(new QueryYieldReport(app('em')), new BoxExportReport());

        $report = app('em')->find(Report::class, 6);

        $generate->generateReport($report, ReportFormat::CSV, "/var/www/html/src/generated-report.csv");
    }
}