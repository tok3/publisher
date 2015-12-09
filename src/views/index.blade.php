@extends('tok3-publisher::layout.pages')

@section('meta')
<meta name="robots" content="noindex, follow">
@endsection

@section('content')
<div class="container">

    <div class="blog-header">
        <h1 class="blog-title">The Laravel Publisher</h1>
        <p class="lead blog-description">The official example template of L51 Publisher by tok3.</p>
    </div>

    <div class="row">

        <div class="col-sm-8 blog-main">

            @foreach ($pages as $page)

            <div class="blog-post">
                    <h3 class="blog-post-title">{{ $page->heading }}</h3>
                    <p class="blog-post-meta">{{ $page->published_at->formatLocalized(Config::get('tok3-publisher.date_format_localized','%d. %B %Y'))  }}</p>

                    <p>
                        {{ $page->teaser }}
                    </p>
                    <p>
                        <a href="{{ url($page->page_url) }}">Read More...</a>

                    </p>
                </div><!-- /.blog-post -->


            @endforeach

                {!! $pages->render() !!}

        </div><!-- /.blog-main -->
        <div class="col-sm-3 col-sm-offset-1 blog-sidebar">

            <div class="sidebar-module">
                <h4>Archives</h4>
                <ol class="list-unstyled">
                    @foreach (\Publisher::archive() as $arc)
                        <li><a href="{{ $arc['link'] }}">{{$arc['txt']}}</a></li>
                        @endforeach
                </ol>
            </div>

        </div><!-- /.blog-sidebar -->

    </div><!-- /.row -->

</div><!-- /.container -->

@endsection