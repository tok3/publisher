@extends('tok3-publisher::layout.pages')

@section('content')

    <div class="content">


        @if($method == 'post')

            {!! Form::open(array('action' => '\Tok3\Publisher\Http\PagesController@store', 'files' => true)) !!}

        @else
            {!! Form::open(array('action' => ['\Tok3\Publisher\Http\PagesController@update',$page->id], 'method'=>'patch','files' => true)) !!}
        @endif
        {!!Form::hidden('page[ip]',\Request::getClientIp())!!}

        <div class="hpanel">
            <div class="panel-heading hbuilt">
                <div class="panel-tools">
                    <a class="" href="{!! url(Config::get('tok3-publisher.route_admin_pages','publisher-pages')) !!}">[BACK]</a>
                    <a class="" href="{!! url(Config::get('tok3-publisher.route_admin_pages','publisher-pages')) !!}/create">[NEW]</a>
                    <a class="" href="{!! url(Config::get('tok3-publisher.route_admin_pages','publisher-pages')) !!}/{!! $page->id !!}/delete">[DELETE]</a>
                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    <a href="#"><i class="fa fa-times"></i></a>
                </div>
                <h1>Page</h1>
            </div>
            <div class="panel-body">

                @if($page->id)
                    <div class="form-group">
                        {!! Form::label('page[slug]', 'Slug:') !!}

                        {!! $page->slug !!}

                    </div>
                    @if($page->ip == \Request::getClientIp())
                        <div class="form-group">
                            {!! Form::label('prevlink', 'preview link:') !!}

                            <div>
                                <a class="" href="{{ url('tok3-pp/' . $page->slug) }}" target="_blank">[PREVIEW]</a>
                            </div>

                        </div>
                    @endif
                @endif
                <div class="form-group">
                    {!! Form::select('page[domain_id]',$domains, $page->domain_id) !!}

                </div>

                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group text-right">
                            {!! Form::label('page[published]', 'published:') !!}

                            <div>
                                {!!Form::hidden('page[published]','0')!!}
                                {!! Form::checkbox('page[published]', '1', $page->published) !!}
                            </div>

                        </div>
                    </div>
                    <div class="col-md-2">

                        <div class="form-group">
                            {!! Form::label('page[published_at]', 'published_at:') !!}

                            {!! Form::date('page[published_at]', ($page->published_at != '') ? $page->published_at : \Carbon\Carbon::now(), ['class'=>'form-control'] ) !!}

                        </div>
                    </div>

                </div>


                <div class="form-group">
                    {!! Form::label('page[title]', 'title:') !!}


                    {!! Form::text('page[title]',$page->title,['class'=>'form-control','id'=>'title'] ) !!}
                </div>
                @if(!$page->id)
                    <div class="form-group">
                        {!! Form::label('page[slug]', 'Slug:') !!}

                        {!! Form::text('page[slug]',$page->slug,['class'=>'form-control','id'=>'slug'] ) !!}

                    </div>
                @endif
                <div class="form-group">
                    {!! Form::label('images[top]', 'Top Image:') !!}
                    {!! Form::file('images[top]') !!}
                    {!! Form::file('images[left]') !!}

                    @if(!empty( $party->expose->logo))

                        <img id="compLogoForm" src="{{asset('images/comp_logos/' . $party->expose->logo)}}" class="img-aside m-b pull-right" alt="Firmenlogo">
                    @endif
                </div>

                <div class="form-group">
                    {!! Form::label('page[heading]', 'heading:') !!}

                    {!! Form::text('page[heading]',$page->heading,['class'=>'form-control'] ) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('page[teaser]', 'teaser:') !!}

                    {!! Form::text('page[teaser]',$page->teaser,['class'=>'form-control'] ) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('page[text]', 'text:') !!}

                    {!! Form::textarea('page[text]',$page->text,['class'=>'form-control'] ) !!}
                </div>


                <div class="form-group">
                    {!! Form::label('page[meta_description]', 'meta_description:') !!}

                    {!! Form::textarea('page[meta_description]',$page->meta_description,['class'=>'form-control'] ) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('page[meta_keywords]', 'meta_keywords:') !!}

                    {!! Form::textarea('page[meta_keywords]',$page->meta_keywords,['class'=>'form-control'] ) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('page[schema]', 'schema:') !!}

                    {!! Form::textarea('page[schema]',$page->schema,['class'=>'form-control'] ) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('page[open_graph]', 'open_graph:') !!}

                    {!! Form::textarea('page[open_graph]',$page->open_graph,['class'=>'form-control'] ) !!}
                </div>


                {!! Form::submit('Save',['class'=>'btn btn-md btn-primary']) !!}
                {!! Form::close()!!}

            </div> {{--/panel-body--}}
        </div> {{--/.hpanel--}}

    </div>
@endsection


@section('javascript')
    <script>
        $(document).ready(function () {


            $("#title").keyup(function () {
                var $this = $(this);
                window.setTimeout(function () {
                    $("#slug").val(slug($this.val()));
                }, 0);
            });

            console.log(slug('Ärmel müssen so kurz sein daß möchten VERWÄSSERN Österreich in Ümslüt'));


        });


        var slug = function (str) {
            str = str.replace(/^\s+|\s+$/g, ''); // trim
            str = str.toLowerCase();

            // replace german umlaute
            str = str.replace(/ä/g, "ae")
                    .replace(/ö/g, "oe")
                    .replace(/ü/g, "ue")
                    .replace(/Ä/g, "Ae")
                    .replace(/Ö/g, "Oe")
                    .replace(/Ü/g, "Ue")
                    .replace(/ß/g, "ss");


            // remove accents, swap ñ for n, etc
            var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
            var to = "aaaaaeeeeeiiiiooooouuuunc------";
            for (var i = 0, l = from.length; i < l; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }

            str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                    .replace(/\s+/g, '-') // collapse whitespace and replace by -
                    .replace(/-+/g, '-'); // collapse dashes

            return str;
        };


    </script>

@endsection