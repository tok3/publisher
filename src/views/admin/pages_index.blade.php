@extends('tok3-publisher::layout.pages')


@section('content')
<div class="container">


    <div class="row">

        <div class="col-sm-12 blog-main">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Pages</div>

                <!-- Table -->
                <table class="table" style="white-space:nowrap;">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Published at</th>
                        <th>Heading</th>
                        <th>Teaser</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($pages as $page)

                        <tr>
                            <td>{{ $page->id }}</td>
                            <td>{{ $page->published_at->formatLocalized('%d.%m.%Y')  }}</td>
                            <td>{{ substr($page->heading,0,50 )}} ...</td>
                            <td>{{ substr($page->page_url,0,50 )}} ...</td>
                            <td>   <a class="pull-right" href="{{ url(Config::get('tok3-publisher.route_admin_pages','publisher-pages') . '/' . $page->id) }}/edit">[EDIT]</a></td>
                             </tr>

            @endforeach
                    </tbody>
                </table>
            </div>

            {!! $pages->render() !!}

        </div><!-- /.blog-main -->
        <div class="col-sm-3 col-sm-offset-1 blog-sidebar">


    </div><!-- /.row -->

</div><!-- /.container -->

@endsection