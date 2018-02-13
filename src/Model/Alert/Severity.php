<?php

namespace Emporium\Svc\Alert\Model\Alert;

final class Severity {
    
    const CRITICAL = 0;
    const ERROR = 1;
    const WARNING = 2;
    const NOTICE = 3;
    const INFO = 4;
    const DEBUG = 5;

    public static function all() {
        return [self::DEBUG, self::INFO, self::NOTICE, self::WARNING, self::ERROR, self::CRITICAL];
    }

    /**
     * Return all severities up to a threshold severity
     * @param  [type] $severityThreshold [description]
     * @return [type]                     [description]
     */
    public static function allWithinThreshold($severityThreshold) {

    	return array_filter(
            self::all(),
            function ($value) use($severityThreshold) {
                return ($value >= $severityThreshold);
            }
        );
    }
}
