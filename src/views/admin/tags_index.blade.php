@extends('tok3-publisher::layout.pages')


@section('content')
    <div class="container">


        <div class="row">

            <div class="col-sm-12 blog-main">
                <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="panel-heading">Tags <a class="" href="{!! url(Config::get('tok3-publisher.route_admin_tags','publisher-tags')) !!}/create">[ADD NEW]</a></div>
                    <div class="panel-body">
                        <!-- Table -->


                        <table class="table" id="tagTable" style="white-space:nowrap;">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($tags as $tag)

                                <tr>
                                    <td>{{ $tag->id }}</td>
                                    <td>{{ $tag->name }}</td>
                                    <td>{{ $tag->slug }}</td>
                                    <td>{{ $tag->created_at->formatLocalized('%d.%m.%Y')  }}</td>
                                    <td>{{ $tag->updated_at->formatLocalized('%d.%m.%Y')  }}</td>
                                    <td>
                                        <a class="pull-right" href="{{ url(Config:: get('tok3-publisher.route_admin_tags','publisher-tags') . '/' . $tag->id) }}/edit">[EDIT]</a>
                                        <a class="pull-right" style="margin-right:10px;" href="{!! url(Config::get('tok3-publisher.route_admin_tags','publisher-tags')) !!}/{!! $tag->id !!}/delete">[DELETE]</a>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- /.blog-main -->
            <div class="col-sm-3 col-sm-offset-1 blog-sidebar">


            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->

        @endsection
        @section('javascripts')
            <script>


                $(document).ready(function () {

                    $('#tagTable').dataTable();


                });
            </script>

@endsection