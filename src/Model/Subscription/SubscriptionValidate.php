<?php

namespace Emporium\Svc\Alert\Model\Subscription;

use Emporium\Svc\Alert\Model\{Subscriber};

class SubscriptionValidate
{
    /**
     * Check a collection of subscriptions for matching categories
     * @param  [type] $subscriptions [description]
     * @return [type]                [description]
     */
    public function gateCheckSubscriptionIsUnique(Subscriber\Subscriber $subscriber, $category)
    {
        $subscriptions = $subscriber->subscriptions;

        // Check for existing subscriptions
        if (count($subscriptions)) {
            
            // Iterate over existing subscriptions
            foreach ($subscriptions as $subscription) {
                
                // Check if any existing subscriptions share the same category
                if ($subscription->category == $category) {
                    
                    abort(422, 'Error: Subscription already exists on this category');
                
                } 
            }
        }
    }
}
