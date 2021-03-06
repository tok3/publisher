@extends('tok3-publisher::layout.pages')

@section('content')

    <div class="container">


        @if($method == 'post')

            {!! Form::open(array('action' => '\Tok3\Publisher\Http\DomainsController@store', 'files' => true)) !!}

        @else
            {!! Form::open(array('action' => ['\Tok3\Publisher\Http\DomainsController@update',$domain->id], 'method'=>'patch','files' => true)) !!}
        @endif


        <div class="hpanel">
            <div class="panel-heading hbuilt">
                <h3>Domain</h3>

                <div class="panel-tools">

                    <a class="" href="{!! url(Config::get('tok3-publisher.route_admin_domains','publisher-domains')) !!}">[BACK]</a>

                    <a class="" href="{!! url(Config::get('tok3-publisher.route_admin_domains','publisher-domains')) !!}/{!! $domain->id !!}/delete">[DELETE]</a>
                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    <a href="{!!\URL::to('domains')!!}"><i class="fa fa-times"></i></a>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        {!! Form::label('domain[name]', 'name:') !!}


                        {!! Form::text('domain[name]',$domain->name,['class'=>'form-control','id'=>'name'] ) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('domain[slug]', 'slug:') !!}


                        {!! Form::text('domain[slug]',$domain->slug,['class'=>'form-control','id'=>'slug'] ) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('domain[description]', 'description:') !!}


                        {!! Form::text('domain[description]',$domain->description,['class'=>'form-control','id'=>'description'] ) !!}
                    </div>
                    {!! Form::submit('Save',['class'=>'btn btn-md btn-primary']) !!}
                    {!! Form::close()!!}
                </div>

            </div> {{--/.hpanel--}}

        </div>
        @endsection


        @section('javascripts')
            <script>
                $(document).ready(function () {

                    $("#name").keyup(function () {
                        var $this = $(this);
                        window.setTimeout(function () {
                            $("#slug").val(slug($this.val()));
                        }, 0);
                    });
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