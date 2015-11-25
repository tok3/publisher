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
 add to your composer.json
 `"tok3/publisher": "@beta"`

#### Service Provider
`Tok3\Publisher\PublisherServiceProvider::class`

**Laravel 5.1**
` 'Publisher' => Tok3\Publisher\PublisherFacade::class,`



