<?php

namespace Emporium\Svc\Alert\Model\Report;

use Emporium\Svc\Alert\Model\{Alert};
use Krak\AQL;

use function Emporium\Svc\Alert\Http\exceptionResponse;

class ValidateReport
{
    public $aql_engine;

    public function __construct(AQL\Engine $aql_engine)
    {
        $this->aql_engine = $aql_engine;
    }

    /**
     * Use the AQL engine from the AlertSearch class
     * to ensure that the query we are saving for the 
     * report is a valid Alert search query
     * @param  [type] $query [description]
     * @return [type]        [description]
     */
    public function validateReportQuery($query) {
        
        try {
            
            $aql_engine = Alert\AlertSearch::createEngine();
            $aql_engine->process($query);

        } catch (AQLException $e) {

            return exceptionResponse(400, 'bad_request', $e);
        }
    }
}
