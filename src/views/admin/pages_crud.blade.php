@extends('tok3-publisher::layout.pages')

@section('content')

    <div class="container">


        @if($method == 'post')

            {!! Form::open(array('action' => '\Tok3\Publisher\Http\PagesController@store', 'files' => true)) !!}

        @else
            {!! Form::open(array('action' => ['\Tok3\Publisher\Http\PagesController@update',$page->id], 'method'=>'patch','files' => true)) !!}
        @endif
        {!!Form::hidden('page[ip]',\Request::getClientIp())!!}

        <div class="hpanel hpanel row" id="contentTabs">
            <ul class="nav nav-tabs nav-tabs-cont">
                <li class="active"><a data-toggle="tab" href="#tab-1">Content</a></li>
                @if($method != 'post')

                    <li class=""><a data-toggle="tab" href="#tab-2">Meta & SEO</a></li>
                @endif
            </ul>
            <div class="panel-heading hbuilt">
                <div class="panel-tools">

                    <a class="" href="{!! url(Config::get('tok3-publisher.route_admin_pages','publisher-pages')) !!}">[BACK]</a>

                    <a class="" href="{!! url(Config::get('tok3-publisher.route_admin_pages','publisher-pages')) !!}/{!! $page->id !!}/delete">[DELETE]</a>
                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    <a href="{!!\URL::to('pages')!!}"><i class="fa fa-times"></i></a>
                </div>
                <h3>Page</h3>
            </div>
            <div class="panel-body">
                <div class="tab-content ">
                    <div id="tab-1" class="tab-pane active ">
                        @include('tok3-publisher::admin._page_content')
                    </div>
                    <div id="tab-2" class="tab-pane">
                        @include('tok3-publisher::admin._page_seo')
                    </div>
                </div>{{--/.tab-content--}}
                {!! Form::submit('Save',['class'=>'btn btn-md btn-primary']) !!}
                {!! Form::close()!!}

            </div> {{--/panel-body--}}
        </div> {{--/.hpanel--}}

    </div>
@endsection


@section('javascripts')
    <script>
        $(document).ready(function () {

            $("#title").keyup(function () {
                var $this = $(this);
                window.setTimeout(function () {
                    $("#slug").val(slug($this.val()));
                }, 0);
            });


            $('#tag_list').select2({
                placeholder: "Select or add tags",
                tags: true,
                tokenSeparators: [",", " "],
                createTag: function (newTag) {
                    return {
                        id: '(+)' + newTag.term,
                        text: newTag.term + ' (+) '
                    };
                }
            });

            $('.nav-tabs-cont a').each(function () {
                $(this).click(function () {

                    index = $('.nav-tabs a[href="' + $(this).attr('href') + '"]').parent().index();
                    sessionStorage['tab_id'] = index;
                });
            });

            if (typeof sessionStorage['tab_id'] === 'undefined') {
                sessionStorage['tab_id'] = 0;
            }

            $('#contentTabs li:eq(' + parseInt(sessionStorage['tab_id']) + ') a').tab('show'); // Select tab by name


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