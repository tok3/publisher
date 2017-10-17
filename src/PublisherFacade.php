<?php
namespace Tok3\Publisher;

use Illuminate\Support\Facades\Facade;

class PublisherFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'tok3-publisher';
    }
}