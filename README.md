# publisher




## Quick Installation

## while beta
`
"repositories": [
        {
            "type": "package",
            "package": {
                "name": "tok3/laravel42-firebird-support",
                "version": "1.0",
                "dist": {
                    "url": "https://github.com/tok3/laravel42-firebird-support/archive/master.zip",
                    "type": "zip"
                },
                "source": {
                    "url": "https://github.com/tok3/laravel42-firebird-support.git",
                    "type": "git",
                    "reference": "dev-master"
                }
            }
        }
    ],
`
**Laravel 5.1:**
 add to your composer.json
 `"tok3/laravel42-firebird-support": "@beta"`

#### Service Provider
`Tok3\Publisher\PublisherServiceProvider::class`

**Laravel 5.1**
` 'Publisher' => Tok3\Publisher\PublisherFacade::class,`


And that's it! Start build and publish pages and articles!

## License

Licensed under the [MIT License](https://github.com/yajra/laravel-datatables/blob/master/LICENSE).


