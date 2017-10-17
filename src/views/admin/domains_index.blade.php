@extends('tok3-publisher::layout.pages')


@section('content')
    <div class="container">


        <div class="row">

            <div class="col-sm-12 blog-main">
                <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="panel-heading">Domains <a class="" href="{!! url(Config::get('tok3-publisher.route_admin_domains','publisher-domains')) !!}/create">[ADD NEW]</a></div>
                    <div class="panel-body">
                        <!-- Table -->


                        <table class="table" id="domainTable" style="white-space:nowrap;">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($domains as $domain)

                                <tr>
                                    <td>{{ $domain->id }}</td>
                                    <td>{{ $domain->name }}</td>
                                    <td>{{ $domain->created_at->formatLocalized('%d.%m.%Y %H:%I.%S')  }}</td>
                                    <td>{{ $domain->updated_at->formatLocalized('%d.%m.%Y %H:%I.%S')  }}</td>
                                    <td>
                                        <a class="pull-right" href="{{ url(Config:: get('tok3-publisher.route_admin_domains','publisher-domains') . '/' . $domain->id) }}/edit">[EDIT]</a>
                                        <a class="pull-right" style="margin-right:10px;" href="{!! url(Config::get('tok3-publisher.route_admin_domains','publisher-domains')) !!}/{!! $domain->id !!}/delete">[DELETE]</a>
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

                    $('#domainTable').dataTable();


                });
            </script>

@endsection