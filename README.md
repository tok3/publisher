# publisher
## Quick Installation
## beta 

Add this to your application composer.json to bypass packagist: 
```
"repositories": [
        {
            "type": "package",
            "package": {
                "name": "tok3/publisher",
                "version": "1.0",
                "dist": {
                    "url": "https://github.com/tok3/publisher/archive/master.zip",
                    "type": "zip"
                },
                "source": {
                    "url": "https://github.com/tok3/publisher/archive/master.zip",
                    "type": "git",
                    "reference": "dev-master"
                }
            }
        }
    ],
```

**Laravel 5.1:**
<br>add `"tok3/publisher": "@beta"` to your composer.json
 

#### Service Provider
`Tok3\Publisher\PublisherServiceProvider::class`

**Laravel 5.1**<br>
` 'Publisher' => Tok3\Publisher\PublisherFacade::class,`



## Migration

run `php artisan vendor:publish`<br>
after that `php artisan migrate`


### Now you are done !
Explore the package visit: <b>http://localhost:8000/publisher/pages</b> (assumed using artisan)

when you need some fake data you'll find a seeder in `vendor/tok3/publisher/src/seeds`


Routes and so on can changed in the config `config/tok3-publisher.php`<br>
Views are stored in `resources/views/vendor/tok3-publisher/`


