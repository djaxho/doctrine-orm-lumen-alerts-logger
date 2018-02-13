<?php

namespace Emporium\Svc\Alert\Http\Controller;

use Illuminate\Http\Request;
use Emporium\Svc\Alert\Model\{Report};
use Doctrine\ORM\EntityManagerInterface;
use Krak\Marshal;

class ReportController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Retrieve all reports
     * @param  Request $req [description]
     * @return [type]       [description]
     */
    public function index(Request $req)
    {
        $repository = $this->em->getRepository(Report\Report::class);
        
        $m = Marshal\map(marshalEntity());
        return response()->json($m($repository->findAll()));
    }

    /**
     * Retrieve a report
     * @param  [type]              $id            [description]
     * @return [type]                             [description]
     */
    public function show($id)
    {
        $report = $this->em->find('Alert:Report\Report', $id);

        $m = marshalEntity();
        return response()->json($m($report));
    }

    /**
     * Update a report
     * @param  [type]              $id            [description]
     * @param  Request             $req           [description]
     * @param  Report\UpdateReport $update_report [description]
     * @return [type]                             [description]
     */
    public function update($id, Request $req, Report\UpdateReport $update_report)
    {
        // Validate the severity && category
        $this->validate($req, [
            'name' => 'required|string',
            'query' => 'required|string'
        ]);

        // Update the report
        $report = $update_report->updateReportFromArray($id, $req->all());

        $m = marshalEntity();
        return response()->json($m($report));
    }

    /**
     * Store a report
     * @return [type]                        [description]
     */
    public function postReportAction(Request $req, Report\StoreReport $store_report) {

        // Validate the post fields
        $this->validate($req, [
            'name' => 'required|string',
            'query' => 'required|string'
        ]);

        // Store the report
        $report = $store_report->storeReportFromArray($req->all());

        $m = marshalEntity();
        return response()->json($m($report));
    }
}
