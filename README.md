# composer-tutor-proxy-provider

Permets aux differentes applications d'avoir un proxy vers intra-tuteur-api

## Installation

Modifier `composer.json` :

```
{
    // ...
    "require": {
        "etna/tutor-proxy-provider": "~2.0.x"
    },
    "repositories": [
       {
           "type": "composer",
           "url": "https://blu-composer.herokuapp.com"
       }
   ]
}
```

## Utilisation

### Déclarer le composant

Le composant `etna/config-provider` met à disposition une classe permettant de faire utiliser ce proxy a notre application.

```
use ETNA\Silex\Provider as ETNAProvider;

class EtnaConfig implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        ...
        $app->register(new ETNAProvider\TutorProxy\TutorProxy());
        ...
    }
}
```

Il faut également ajouter dans l'env les adresses respectives de l'intra-tuteur-api.
```
Dev env:
    putenv("TUTOR_API_URL=http://intra-tuteur-api.etna.dev");

prod env:
    putenv("TUTOR_API_URL=http://intra-tuteur-api.etna-alternance.net");

test env:
    putenv("TUTOR_API_URL=http://127.0.0.1");
```

Pour faire appel à une méthode du proxy utilisez:
```
    $app["tutor"]->ma_méthode();
```

la route de l'api intra tuteur peut être appelée en faisait
`$app->["tutor_proxy"]`
