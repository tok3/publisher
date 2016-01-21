<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($pages as $page)
        <url>
            <loc>{{ url($page->page_url) }}</loc>
            <lastmod>{!! $page->updated_at->format('Y-m-d\TH:i:sP') !!}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.5</priority>
        </url>

    @endforeach

</urlset>