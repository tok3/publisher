@extends('tok3-publisher::layout.pages')

@section('title')
    {{$page->title}}
@endsection

@section('content')


<div class="container">

    <div class="blog-header">
        <h1 class="blog-title">The Laravel Publisher</h1>
        <p class="lead blog-description">The official example template of L51 Publisher by tok3.</p>
    </div>

    <div class="row">
        <div class="col-sm-8 col-md-8">
            <div class="blog-post">
                <ul class="list-inline post-detail">
                    <li><i class="fa fa-calendar"></i> {{ $page->published_at->formatLocalized('%d. %B %Y')  }}</li>
                    </ul>
                <h2>{{$page->heading}}</h2>
                <p class="lead">
                    {{$page->teaser}}
                 </p>
                <p>
                    {{$page->text}}
                </p>
            </div><!--blog post-->


            <ul class="pager pull-left">
                <li class="back"><a href="{!!  isset($domain_slug) ? url($domain_slug) : url(Config::get('tok3-publisher.default_route','publisher')) !!}">← Previous Page</a></li>

            </ul><!--pager-->
            <div class="divide60"></div>

        </div><!--col-->
        <div class="col-sm-3 col-sm-offset-1 col-md-3 col-md-offset-1">
            <div class="sidebar-box margin40">
                <h4>Search</h4>
                <form class="search-widget" role="form">
                    <input type="text" class="form-control">
                    <i class="fa fa-search"></i>
                </form>
            </div><!--sidebar-box-->
            <div class="sidebar-box margin40">
                <h4>Text widget</h4>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam, adipiscing condimentum tristique vel, eleifend sed turpis. Pellentesque cursus arcu id magna euismod in elementum purus molestie.
                </p>
            </div><!--sidebar-box-->
            <div class="sidebar-box margin40">
                <h4>Categories</h4>
                <ul class="list-unstyled cat-list">
                    @foreach (\Tok3\Publisher\Models\Domain::get() as $domain)
                        <li {!!  (\Request::is($domain->slug) ? ' class="active"' : '')  !!}><a href="{{ url($domain->slug) }}">{!! $domain->name !!}</a></li>
                        @endforeach
                </ul>
            </div><!--sidebar-box-->

            <div class="sidebar-box margin40">
                <h4>Tag Cloud</h4>
                <div class="tag-list">
                    <a href="#">Wordpress</a>
                    <a href="#">Design</a>
                    <a href="#">Graphics</a>
                    <a href="#">Seo</a>
                    <a href="#">Development</a>
                    <a href="#">Marketing</a>
                    <a href="#">fashion</a>
                    <a href="#">Media</a>
                    <a href="#">Photoshop</a>
                </div>
            </div>
        </div><!--sidebar-col-->
    </div>

</div><!-- /.container -->


@endsection


