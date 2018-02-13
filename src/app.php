<?php

namespace Emporium\Svc\Alert;

use Illuminate\Http\Request;

require_once __DIR__ . '/Http/Controller/marshal.php';
require_once __DIR__ . '/Http/http.php';

function app($service = null, array $parameters = []) {
    static $app;

    if (!$app) {
        $app = createApp();
    }

    if (!$service) {
        return $app;
    }

    return $app->make($service, $parameters);
}

function createApp() {
    $app = new \Laravel\Lumen\Application(realpath(__DIR__ . '/../'));
    $app->register(AlertServiceProvider::class);
    $app->get('/_status', function() {
        return [
            'server_status' => 'OK',
            'date' => date('r'),
        ];
    });

    $app->group(['namespace' => 'Emporium\Svc\Alert\Http\Controller'], function($app) {
$app->get('/tester', 'TestController@test');
        // Store alert
        $app->post('/alerts', 'AlertController@postAlertAction');
        // Retrieve all alerts // Can filter via ?threshold ?severity ?category query string
        $app->get('/alerts', 'AlertController@index');
        // Retrieve an alert by id
        $app->get('/alerts/{id}', 'AlertController@show');

        // Store subscriber
        $app->post('/subscribers', 'SubscriberController@postSubscriberAction');
        // Retrieve all subscribers
        $app->get('/subscribers', 'SubscriberController@index');
        // Update a subscription
        $app->put('/subscribers/subscriptions/{id}', 'SubscriptionController@update');
        // Retrieve a subscriber by id
        $app->get('/subscribers/{id}', 'SubscriberController@show');

        // Subscribe a use to a category && severity
        $app->post('/subscribers/{id}/subscriptions', 'SubscriptionController@postSubscriptionAction');
        // Retrieve a subscriber's applicable alerts
        $app->get('/subscribers/{id}/subscriptions', 'SubscriberController@subscriptions');

        // Retrieve all existing categories
        $app->get('/categories', 'CategoryController@index');

        // Store report
        $app->post('/reports', 'ReportController@postReportAction');
        // Retrieve reports
        $app->get('/reports', 'ReportController@index');
        // Retrieve a report by id
        $app->get('/reports/{id}', 'ReportController@show');
        // Update a report
        $app->put('/reports/{id}', 'ReportController@update');

    });
    $app->get('/queue', function(\Illuminate\Contracts\Bus\Dispatcher $dispatch) {
        $rand = rand();
        $dispatch->dispatch(new Job\ProcessAlertJob($rand));
        return ['data' => $rand];
    });

    return $app;
}

function initApp() {
    try {
        (new \Dotenv\Dotenv(__DIR__.'/../'))->overload(true);
    } catch (\Dotenv\Exception\InvalidPathException $e) {

    }
}
