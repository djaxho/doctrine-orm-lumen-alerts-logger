<?php

namespace Emporium\Svc\Alert\Model\Subscription;

use Emporium\Svc\Alert\Model\{Subscriber};
use Doctrine\ORM\EntityManagerInterface;

class StoreSubscription
{
    private $em;
    private $subscription_validator;

    public function __construct(EntityManagerInterface $em, SubscriptionValidate $subscription_validator) {
        $this->em = $em;
        $this->subscription_validator = $subscription_validator;
    }

    /**
     * Retrieve the Subscriber object using the subscriber id
     * @param  [type] $subscriber_id [description]
     * @return [type]                [description]
     */
    private function retrieveSubscriber($subscriber_id)
    {
        // Retrieve subscriber entity
        $subscriber = $this->em->find('Alert:Subscriber\Subscriber', $subscriber_id);

        if (! $subscriber) { 

            abort(500, 'Invalid subscriber'); 
        }

        return $subscriber;
    }

    /**
     * Instantiate the subscription object and store in the db
     * @param  Subscriber\Subscriber $subscriber [description]
     * @param  [type]                $category   [description]
     * @param  [type]                $severity   [description]
     * @return [type]                            [description]
     */
    public function storeSubscription(Subscriber\Subscriber $subscriber, $category, $severity)
    {
        $this->subscription_validator->gateCheckSubscriptionIsUnique($subscriber, $category);

        $subscription = new Subscription(
            $subscriber,
            $category,
            $severity
        );

        $this->em->persist($subscription);
        $this->em->flush();

        return $subscription;
    }

    /**
     * Update the severity level of an existing subscription
     * @param  Subscription $subscription [description]
     * @param  [type]       $severity     [description]
     * @return [type]                     [description]
     */
    public function updateCurrentSubscriptionSeverityLevel(Subscription $subscription, $severity)
    {
        $subscription->severity = $severity;

        $this->em->persist($subscription);
        $this->em->flush();

        return $subscription;
    }

    /**
     * Instantiate and store the subscription from an array
     * @param  [type] $subscriber_id         [description]
     * @param  [type] $subscription_criteria [description]
     * @return [type]                        [description]
     */
    public function storeSubscriptionFromArray($subscriber_id, $subscription_criteria) 
    {
        // Default value
        $subscriptionWithSameCategoryExists = false;

        $subscriber = $this->retrieveSubscriber($subscriber_id);

        $subscription = $this->storeSubscription(
            $subscriber,
            $subscription_criteria['category'],
            $subscription_criteria['severity']
        );

        return $subscription;
    }
}
