<?php

namespace Emporium\Svc\Alert\Http\Controller;

use Illuminate\Http\Request;
use Emporium\Svc\Alert\Model\{Alert, Alert\Severity};
use Doctrine\ORM\EntityManagerInterface;
use Krak\Marshal,
    Krak\AQL\AQLException;

use function Emporium\Svc\Alert\Http\exceptionResponse;

class AlertController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function index(Request $req, Alert\AlertSearch $alert_search)
    {
        try {
            $alerts = $alert_search->searchAlerts(
                $req->input('q'),
                $req->input('page', 1),
                $req->input('per_page', 100)
            );

            return response()->json($alerts->withMarshaledItems(marshalEntity()));
        } catch (AQLException $e) {
            return exceptionResponse(400, 'bad_request', $e);
        }
    }

    /**
     * Retrieve single alert
     * @param  [type]                 $id [description]
     * @return [type]                     [description]
     */
    public function show($id)
    {
        $repository = $this->em->getRepository(Alert\Alert::class);

        $m = marshalEntity();
        return response()->json($m($repository->find($id)));
    }

    /**
     * Store an alert
     * @param  Alert\StoreAlert $store_alert [description]
     * @return [type]                        [description]
     */
    public function postAlertAction(Request $req, Alert\StoreAlert $store_alert) {

        // Validate the post fields
        $this->validate($req, [
            'msg' => 'required|string',
            'category' => 'required|string',
            'payload' => 'required|array',
            'severity' => 'required|string|in:' . implode(',', Severity::all()),
        ]);

        // Store the alert
        $alert = $store_alert->storeAlertFromArray($req->all());

        $m = marshalEntity();
        return response()->json($m($alert));
    }
}
