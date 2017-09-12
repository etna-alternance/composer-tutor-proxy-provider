<?php

namespace ETNA\Silex\Provider\TutorProxy;

use GuzzleHttp\Client;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class TutorProxy implements ServiceProviderInterface
{
    private $controller_instance = null;

    public function __construct($controller_instance = null)
    {
        $this->controller_instance = $controller_instance;
    }

    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        $app["tutor_proxy"] = function ($app) {
            $conversation_api_url = getenv("TUTOR_API_URL");
            if (false === $conversation_api_url) {
                throw new \Exception("TutorProxyProvider needs env var TUTOR_API_URL");
            }
            if (false === getenv("TRUSTED_DOMAIN")) {
                throw new \Exception("TutorProxyProvider needs env var TRUSTED_DOMAIN");
            }

            return new Client([
                "base_uri" => $conversation_api_url
            ]);
        };

        $app["tutor"] = function ($app) {
            return new TutorManager($app);
        };

        $app->mount("/", $this->controller_instance);
    }
}
