# GenjShortUrlBundle

Provides a way to redirect requests based on an Entity stored in the database. Features:

* redirect client based on the request path, e.g. '/something'
* internal and external redirects to a path or url
* with start/end datetime
* configurable http status code
* keeps the query string parameters when redirecting



## Installation

Add this to your composer.json:

```
    ...
    "require": {
        ...
        "genj/short-url-bundle": "dev-master"
        ...
```

Then run `composer update`. After that is done, enable the bundle in your AppKernel.php:

```
# app/AppKernel.php
class AppKernel extends Kernel
{
    public function registerBundles() {
        $bundles = array(
            ...
            new Genj\ShortUrlBundle\GenjShortUrlBundle()
            ...
```

Finally, update your database schema:

```
php app/console doctrine:schema:update
```

And you're done.



## Usage

Add a new record to your database. Example:

* source: /my-old-url
* target: /my-new-url
* httpStatusCode: 301
* publishAt: (now)



## FAQ

### My redirect is not working through app.php, but it works through app_dev.php

If you have enabled caching, it can happen that a 404 response is stored in the http cache, so clear your caches. The redirect requests themselves have private caching headers.

