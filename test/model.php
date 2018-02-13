<?php

use Emporium\Svc\Alert\Model\{Alert, Subscriber, Subscription, Alert\Severity};

use function Eloquent\Phony\mock;
use Peridot\Leo\Interfaces\Assert;

describe('Alert', function() {
    describe('StoreAlert', function() {
        it('stores an alert in doctrine', function() {
            $em = mock('Doctrine\ORM\EntityManagerInterface')->get();
            $store_alert = new Alert\StoreAlert($em);
            $alert = $store_alert->storeAlertFromArray([
                'msg' => 'Message',
                'category' => '/orders',
                'severity' => Severity::INFO,
                'payload' => []
            ]);

            assert($alert instanceof Alert\Alert);
        });
    });
    describe('->process()', function() {
        it('it marks the alert as processed', function() {
            $alert = new Alert\Alert('', '', '', []);
            $alert->process();

            assert($alert->processed_at instanceof DateTime);
        });
  });
});

describe('Subscriber', function() {
    describe('StoreSubscriber', function() {
        it('stores a subscriber in doctrine', function() {
            $em = mock('Doctrine\ORM\EntityManagerInterface')->get();
            $store_subscriber = new Subscriber\StoreSubscriber($em);
            $subscriber = $store_subscriber->storeSubscriberFromArray([
                'email' => str_random(10).'@testmail.com',
                'name' => str_random(10)
            ]);

            assert($subscriber instanceof Subscriber\Subscriber);
        });
    });
});

describe('Subscription', function() {
    describe('StoreSubscription', function() {
        it('stores a subscription in doctrine', function() {

            $em = mock('Doctrine\ORM\EntityManagerInterface')->get();
            $store_subscriber = new Subscriber\StoreSubscriber($em);
            $subscriber = $store_subscriber->storeSubscriberFromArray([
                'email' => str_random(10).'@testmail.com',
                'name' => str_random(10)
            ]);

            $subscription_validator = new Subscription\SubscriptionValidate;
            
            $store_subscription = new Subscription\StoreSubscription($em, $subscription_validator);
            
            $subscription = $store_subscription->storeSubscription(
                $subscriber, 
                $category = str_random(10),
                $severity = Severity::INFO
            );

            assert($subscription instanceof Subscription\Subscription);
        });
    });
});

describe('Severity', function() {
    describe("::allWithinThreshold('warning')", function() {
        it('returns all severities below warning', function() {

            $severitiesUnderAndIncludingThreshold = Severity::allWithinThreshold(Severity::WARNING);
            
            expect($severitiesUnderAndIncludingThreshold)
                ->to
                ->not->include(Severity::CRITICAL)
                ->not->include(Severity::ERROR)
                ->include(Severity::WARNING)
                ->include(Severity::NOTICE)
                ->include(Severity::INFO)
                ->include(Severity::DEBUG);
        });
    });
});
