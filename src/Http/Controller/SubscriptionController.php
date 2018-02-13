<?php

namespace Emporium\Svc\Alert\Http\Controller;

use Illuminate\Http\Request;
use Emporium\Svc\Alert\Model\{Subscription, Alert\Severity};
use Doctrine\ORM\EntityManagerInterface;

class SubscriptionController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Store a subscription
     * @param  [type]                         $id      [description]
     * @param  Request                        $req                [description]
     * @param  Subscription\StoreSubscription $store_subscription [description]
     * @return [type]                                             [description]
     */
    public function postSubscriptionAction($id, Request $req, Subscription\StoreSubscription $store_subscription)
    {
        // Validate the severity && category
        $this->validate($req, [
            'category' => 'required|string',
            'severity' => 'required|string|in:' . implode(',', Severity::all()),
        ]);

        // Store the subscription
        $subscription = $store_subscription->storeSubscriptionFromArray($id, $req->all());

        $m = marshalEntity();
        return response()->json($m($subscription));
    }

    /**
     * Store a subscription
     * @param  [type]                         $id      [description]
     * @param  Request                        $req                [description]
     * @param  Subscription\StoreSubscription $store_subscription [description]
     * @return [type]                                             [description]
     */
    public function update($id, Request $req, Subscription\UpdateSubscription $update_subscription)
    {
        // Validate the severity && category
        $this->validate($req, [
            'category' => 'required|string',
            'severity' => 'required|string|in:' . implode(',', Severity::all()),
        ]);

        // Store the subscription
        $subscription = $update_subscription->updateSubscriptionFromArray($id, $req->all());

        $m = marshalEntity();
        return response()->json($m($subscription));
    }
}
