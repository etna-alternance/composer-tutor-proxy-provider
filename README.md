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
