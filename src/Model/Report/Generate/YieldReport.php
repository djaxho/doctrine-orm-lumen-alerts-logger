<?php

namespace Emporium\Svc\Alert\Model\Report\Generate;

use Emporium\Svc\Alert\Model\{Report\Report};

interface YieldReport {

	/** yield the report into rows for serializing */
    public function yieldReport(Report $report);
}