<?php
return [
    'index_pager_items' => '5',
    'default_route' => 'publisher',
    'route_admin_pages' => 'publisher/pages',
    'route_admin_tags' => 'publisher/tags',         // list by tag
    'route_admin_domains' => 'publisher/domains',   // list by domain/category
    'route_sitemap' => 'sitemap.xml',               // route sitemap
    'date_format_localized' => '%d. %B %Y',
    'images_dir' => 'images/tok3-publisher/',
    'views' => [
        'index' => 'tok3-publisher::index',         // view list all paes
        'index_domain' => 'tok3-publisher::index',  // view list by domain / category
        'index_tag' => 'tok3-publisher::index',     // view list by tag
        'index_archive' => 'tok3-publisher::index', // view list by tag
        'page' => 'tok3-publisher::page',           // view normal page
        'article_page' => 'tok3-publisher::page',   // view blog post / article page
    ],
    'admin_views' => [
        'index_pages' => 'tok3-publisher::admin.pages_index',
        'crud_pages' => 'tok3-publisher::admin.pages_crud',
        'index_domains' => 'tok3-publisher::admin.domains_index',
        'crud_domains' => 'tok3-publisher::admin.domains_crud',
        'index_tags' => 'tok3-publisher::admin.tags_index',
        'crud_tags' => 'tok3-publisher::admin.tags_crud',

    ]

];