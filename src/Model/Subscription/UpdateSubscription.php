<?php

namespace Emporium\Svc\Alert\Model\Subscription;

use Emporium\Svc\Alert\Model\{Subscriber};
use Doctrine\ORM\EntityManagerInterface;

class UpdateSubscription
{
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**
     * Retrieve the subscription object using the subscription id
     * @param  [type] $subscription_id [description]
     * @return [type]                [description]
     */
    private function retrieveSubscription($subscription_id)
    {
        // Retrieve subscriber entity
        $subscription = $this->em->find('Alert:Subscription\Subscription', $subscription_id);

        if (! $subscription) { 

            abort(404, 'Invalid subscription'); 
        }

        return $subscription;
    }

    /**
     * Instantiate and store the subscription from an array
     * @param  [type] $subscription_id         [description]
     * @param  [type] $subscription_criteria [description]
     * @return [type]                        [description]
     */
    public function updateSubscriptionFromArray($subscription_id, $subscription_criteria) 
    {
        // Default value
        $subscriptionWithSameCategoryExists = false;

        $subscription = $this->retrieveSubscription($subscription_id);

        $subscription->severity = $subscription_criteria['severity'];
        // Diabled changing category, at it might overlap an existing subscription
        // $subscription->category = $subscription_criteria['category'];

        $this->em->persist($subscription);
        $this->em->flush();

        return $subscription;
    }
}
