<?php

namespace Emporium\Svc\Alert\Http\Controller;

use Illuminate\Http\Request;
use Emporium\Svc\Alert\Model\{Subscriber, Alert};
use Doctrine\ORM\EntityManagerInterface;
use Krak\Marshal;

class SubscriberController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * Retrieve all
     * @param  Request                $req [description]
     * @return [type]                      [description]
     */
    public function index(Request $req)
    {
        $repository = $this->em->getRepository(Subscriber\Subscriber::class);
        
        $m = Marshal\map(marshalEntity());
        return response()->json($m($repository->findAll()));
    }

    /**
     * Get all subscriptions for subscriber
     * @param  Request                $req [description]
     * @return [type]                      [description]
     */
    public function subscriptions($id, Request $req)
    {
        // Set up the repositories
        $subscriptionRepository = $this->em->getRepository(Subscriber\Subscriber::class);
        $alertRepository = $this->em->getRepository(Alert\Alert::class);

        // Retrieve their subscriptions 'belonging to' the particular Subscriber
        $subscriptions = $subscriptionRepository->find($id)->subscriptions;

        $m = Marshal\map(marshalEntity());
        return response()->json($m($subscriptions));
    }

    /**
     * Retrieve by id
     * @param  [type]                 $id [description]
     * @return [type]                     [description]
     */
    public function show($id)
    {
        $repository = $this->em->getRepository(Subscriber\Subscriber::class);

        $m = marshalEntity();
        return response()->json($m($repository->find($id)));
    }

    /**
     * Store a subscriber
     * @param  Request                    $req              [description]
     * @param  Subscriber\StoreSubscriber $store_subscriber [description]
     * @return [type]                                       [description]
     */
    public function postSubscriberAction(Request $req, Subscriber\StoreSubscriber $store_subscriber) {
        
        // Validate request
        $this->validate($req, [
            'email' => 'required|email',
            'name' => 'required'
        ]);

        // Store Subscriber
        $subscriber = $store_subscriber->storeSubscriberFromArray($req->all());

        $m = marshalEntity();
        return response()->json($m($subscriber));
    }
}
