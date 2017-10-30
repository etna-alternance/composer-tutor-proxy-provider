<?php

namespace ETNA\Silex\Provider\TutorProxy;

use GuzzleHttp\Cookie\CookieJar;
use Silex\Application;

use Symfony\Component\HttpFoundation\Request;

class TutorManager
{
    private $app;

    public function __construct(Application $app = null)
    {
        if (null === $app) {
            throw new \Exception("TutorManager requires $app to be set");
        }
        $this->app = $app;
    }

    public function checkContact($contact, $student)
    {
        $response = $this->fireRequest("GET", "/{$contact}/students/{$student}");

        return $response;
    }

    private function fireRequest($method, $uri, $body = [])
    {
        $method = strtoupper($method);

        if (false === in_array($method, ["GET", "POST", "PUT", "DELETE", "OPTIONS"])) {
            return $this->app->abort(405, "TutorProxy can not fire request of method : {$method}");
        }

        $domain = getenv("TRUSTED_DOMAIN");
        $jar    = CookieJar::fromArray(["authenticator" => $this->app["cookies.authenticator"]], $domain);

        try {
            $response = $this->app["tutor_proxy"]->request($method, $uri, [
                "cookies" => $jar,
                "json"    => $body
            ]);

            return json_decode($response->getBody(), true);
        } catch (\GuzzleHttp\Exception\RequestException $client_error) {
            return $this->app->abort(
                $client_error->getResponse()->getStatusCode(),
                json_decode($client_error->getResponse()->getBody(), true)
            );
        }
    }
}
