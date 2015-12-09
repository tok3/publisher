<urlset xmlns="http://www.google.com/schemas/sitemap/0.90">
    @foreach($pages as $page)
        <url>
            <loc>{{ url($page->page_url) }}</loc>
            <lastmod>{!! $page->updated_at->format('Y-m-d\TH:i:sO') !!}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.5</priority>
        </url>

    @endforeach

</urlset>