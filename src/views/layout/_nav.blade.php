<nav class="navbar navbar-default">
    <div class="container-fluid">

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">


                <li {!!  (\Request::is(Config::get('tok3-publisher.default_route','publisher')) ? ' class="active"' : '')  !!}><a href="{{ url(Config::get('tok3-publisher.default_route','publisher')) }}">Pages/Artikles <span class="sr-only"></span></a></li>
                <li class="dropdown
                  @foreach (\Tok3\Publisher\Models\Domain::get() as $domain)

                {!!  (\Request::is($domain->slug) ? ' active' : '')  !!}

                @endforeach
                        ">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Domains <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @foreach (\Tok3\Publisher\Models\Domain::get() as $domain)
                            <li {!!  (\Request::is($domain->slug) ? ' class="active"' : '')  !!}><a href="{{ url($domain->slug) }}">{!! $domain->name !!}</a></li>

                        @endforeach

                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li {!!  (\Request::is(Config::get('tok3-publisher.route_admin_pages','publisher/pages')) ? ' class="active"' : '')  !!}><a href="{{ url(Config::get('tok3-publisher.route_admin_pages','publisher-pages')) }}">Pages/Artikles <span class="sr-only"></span></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>