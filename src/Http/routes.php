<?php
use \Tok3\Publisher\Models\Domain as Domain;

Route::group(Config::get('tok3-publisher.public_route_group_param', []), function ()
{

    // Admin Pages
    Route::resource(Config::get('tok3-publisher.route_admin_pages', 'publisher-pages'), 'Tok3\Publisher\Http\PagesController');
    Route::match(['get', 'delete'], Config::get('tok3-publisher.route_admin_pages', 'publisher-pages') . '/{id}/delete', 'Tok3\Publisher\Http\PagesController@destroy');


    // Admin Tags
    Route::resource(Config::get('tok3-publisher.route_admin_tags', 'publisher-tags'), 'Tok3\Publisher\Http\TagsController');
    Route::match(['get', 'delete'], Config::get('tok3-publisher.route_admin_tags', 'publisher-tags') . '/{id}/delete', 'Tok3\Publisher\Http\TagsController@destroy');

    // Admin Domains/Categories
    Route::resource(Config::get('tok3-publisher.route_admin_domains', 'publisher-domains'), 'Tok3\Publisher\Http\DomainsController');
    Route::match(['get', 'delete'], Config::get('tok3-publisher.route_admin_domains', 'publisher-domains') . '/{id}/delete', 'Tok3\Publisher\Http\DomainsController@destroy');

});

Route::group(Config::get('tok3-publisher.public_route_group_param', []), function ()
{

    // Front
    Route::resource(Config::get('tok3-publisher.default_route', 'publisher'), 'Tok3\Publisher\Http\FrontController');

    // archive
    Route::get(Config::get('tok3-publisher.default_route', 'publisher') . '/archive/{req}', 'Tok3\Publisher\Http\FrontController@archive');

    //sitemap
    Route::get(Config::get('tok3-publisher.route_sitemap', 'sitemap.xml'), 'Tok3\Publisher\Http\FrontController@sitemap');

    // fiterd by tag
    Route::get(Config::get('tok3-publisher.default_route', 'publisher') . '/tag/{req}', 'Tok3\Publisher\Http\FrontController@tag');

    if (Schema::hasTable('tok3_publisher_domains')) // only to avoid errors on migration in case table not yet exists !!!
    {
        foreach (Domain::get() as $domain)
        {
            Route::get($domain->slug . '/{slug}', 'Tok3\Publisher\Http\FrontController@showDomain');
            Route::get($domain->slug, 'Tok3\Publisher\Http\FrontController@indexDomain');
        }
    }

    Route::get('tok3-pp/{slug}', 'Tok3\Publisher\Http\FrontController@preview');

    if (Config::get('tok3-publisher.enable_top_route', FALSE) === TRUE)
    {
        Route::get('{slug}', 'Tok3\Publisher\Http\FrontController@show');
    }


});
