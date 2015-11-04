<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;

$app->before(function (Request $request) {
    if ($request->getMethod() === "OPTIONS") {
        $response = new Response();
        $response->headers->set("Access-Control-Allow-Origin", "*");
        $response->headers->set("Access-Control-Allow-Methods", "GET,POST,PUT,DELETE,OPTIONS");
        $response->headers->set("Access-Control-Allow-Headers", "Content-Type");
        $response->setStatusCode(200);
        return $response->send();
    }
}, Application::EARLY_EVENT);

$app->after(function (Request $request, Response $response) {
    $response->headers->set("Access-Control-Allow-Origin", "*");
    $response->headers->set("Access-Control-Allow-Methods", "GET,POST,PUT,DELETE,OPTIONS");
});

$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : []);
    }
});

$app->view(function (array $controllerResult, \Symfony\Component\HttpFoundation\Request $request) use ($app) {
    $acceptHeader = $request->headers->get('Accept');
    $bestFormat = $app['negotiator']->getBestFormat($acceptHeader, ['json', 'xml']);

    if ('json' === $bestFormat) {
        return new \Symfony\Component\HttpFoundation\JsonResponse($controllerResult);
    }

    if ('xml' === $bestFormat) {
        return $app['serializer.xml']->renderResponse($controllerResult);
    }

    return $controllerResult;
});