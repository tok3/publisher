@extends('tok3-publisher::layout.pages')

@section('title')
    {{$page->title}}
@endsection

@section('meta')
    <meta name="description" content="{!! $page->meta_description !!}"/>

    <meta name="date" content="{!! $page->created_at->format('Y-m-d\TH:i:sO') !!}"/>
    <meta name="last-modified" content="{!! $page->updated_at->format('Y-m-d\TH:i:sO') !!}"/>
    @if($page->type == 1)
        <meta property="og:type" content="article"/>
    @endif
    <meta property="og:title" content="{!! $page->heading !!}"/>
    <meta property="og:description" content="{!! $page->teaser !!}"/>

    @if( $page->images->contains('usage', 'top'))

        <meta property="og:image" content="{!!URL::asset(Config::get('tok3-publisher.images_dir') . $page->image('top')->name) !!}"/>
    @endif


@endsection

@section('content')

    <div class="container">


        <div class="row">
            <div class="col-sm-8 col-md-8">
                <div class="blog-post">
                    @if( $page->images->contains('usage', 'top'))
                        <div>
                            <img class="img-responsive" alt="{!! $page->image('top')->alt !!}" src="{!!URL::asset(Config::get('tok3-publisher.images_dir') . $page->image('top')->name) !!}">
                        </div>
                    @endif
                    @if($page->type == 1)
                        <ul class="list-inline post-detail">
                            <li><i class="fa fa-calendar"></i> {{ $page->published_at->formatLocalized('%d. %B %Y')  }}</li>
                        </ul>
                    @endif
                    <h2>{{$page->heading}}</h2>

                    <p class="lead">
                        {{$page->teaser}}
                    </p>

                    <p>
                        {{$page->text}}
                    </p>
                </div>
                <!--blog post-->


                <ul class="pager pull-left">
                    <li class="back"><a href="{!!  isset($domain_slug) ? url($domain_slug) : url(Config::get('tok3-publisher.default_route','publisher')) !!}">← Previous Page</a></li>

                </ul>
                <!--pager-->
                <div class="divide60"></div>

            </div>
            <!--col-->
            <div class="col-sm-3 col-sm-offset-1 col-md-3 col-md-offset-1">
                <div class="sidebar-box margin40">
                    <h4>Search</h4>

                    <form class="search-widget" role="form">
                        <input type="text" class="form-control">
                        <i class="fa fa-search"></i>
                    </form>
                </div>
                <!--sidebar-box-->
                <div class="sidebar-box margin40 mv-intro">
                    <h4>Lorem ipsum dolor sit amet,</h4>

                    <p style="text-align:justify">
                        consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et
                        ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                    </p>


                </div>
                <!--sidebar-box-->
                <div class="sidebar-box margin40">
                    <h4>Categories</h4>
                    <ul class="list-unstyled cat-list">
                        @foreach (\Tok3\Publisher\Models\Domain::get() as $domain)
                            <li {!!  (\Request::is($domain->slug) ? ' class="active"' : '')  !!}><a href="{{ url($domain->slug) }}">{!! $domain->name !!}</a><i class="fa fa-angle-right"></i></li>
                        @endforeach
                    </ul>
                </div>
                <!--sidebar-box-->

                @if(count($page->tags) > 0)
                <div class="sidebar-box margin40">
                    <h4>Tags</h4>

                    <div class="tag-list">
                        @foreach($page->tags as $tag)
                            <a href="{{url(\Config::get('tok3-publisher.default_route', 'publisher')).'/tag/' . $tag->slug}}">{{$tag->name}}</a>
                        @endforeach
                    </div>
                </div>
                    @endif
            </div>
            <!--sidebar-col-->
        </div>

    </div><!-- /.container -->



@endsection


