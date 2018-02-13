<?php

namespace Emporium\Svc\Alert\Model\Report\Generate;

use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;

class BoxExportReport implements ExportReport
{
    public function exportReport($rows, $format, $dst)
    {
        if($format === Type::CSV || $format === Type::XLSX) {
            $writer = WriterFactory::create($format);
        } else {
            abort(400, 'Unsupported report');
        }

        $writer->openToFile($dst);

        foreach ($rows as $row) {
            $writer->addRow($row);
        }

        $writer->close();
    }
}
