<?php

/**
 * @var Silex\Application $app
 */
$app->error(function (\Exception $e, $code) {
    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:
            $message = $e->getMessage();
    }

    return new \Symfony\Component\HttpFoundation\JsonResponse(['error' => $message, 'code' => $code]);
});