<?php
use \Tok3\Publisher\Models\Domain as Domain;

// Admin
Route::resource(Config::get('tok3-publisher.route_admin_pages','publisher-pages'), 'Tok3\Publisher\Http\PagesController');
Route::get(Config::get('tok3-publisher.route_admin_pages','publisher-pages').'/{id}/delete', 'Tok3\Publisher\Http\PagesController@destroy');


// Front
Route::resource(Config::get('tok3-publisher.default_route','publisher'), 'Tok3\Publisher\Http\FrontController');

if (Schema::hasTable('tok3_publisher_domains')) // only to avoid errors on migration in case table not yet exists !!!
{
    foreach (Domain::get() as $domain)
    {
        Route::get($domain->slug . '/{slug}', 'Tok3\Publisher\Http\FrontController@showDomain');
        Route::get($domain->slug, 'Tok3\Publisher\Http\FrontController@indexDomain');
    }
}
Route::get('tok3-pp/{slug}', 'Tok3\Publisher\Http\FrontController@preview');
Route::get('{slug}', 'Tok3\Publisher\Http\FrontController@show');

