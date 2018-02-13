<?php

namespace Emporium\Svc\Alert\Model\Report\Generate;

interface ExportReport {
    /** export yielded rows into a serialized format into the stream at $dst */
    public function exportReport($rows, $format, $dst);
}