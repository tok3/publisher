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
<div class="row">
    <div class="col-md-3">
        {!! Form::label('page_type', 'Domain/Category:') !!}

        <div class="form-group">
            {!! Form::select('page[domain_id]',$domains, $page->domain_id, ['class' => 'form-control']) !!}

        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('page_type', 'Content Type:') !!}


    <div class="row">
        <div class="col-sm-offset-1 col-sm-2">

            {!! Form::select('page[type]',['0'=>'Content Page', '1'=>'Article / Blog Post'], $page->type, ['class' => 'form-control']) !!}

        </div>
    </div>


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
    @if( $page->images->contains('usage', 'top'))
        <div>
            <img class="img-responsive" style="width:200px;" alt="{!! $page->image('top')->alt !!}" src="{!!URL::asset(Config::get('tok3-publisher.images_dir') . $page->image('top')->name) !!}">
        </div>
    @endif
    {{--    {!! Form::file('images[left]') !!}--}}


</div>

<div class="form-group">
    {!! Form::label('tag_list', 'Tags:') !!}
<small>use _ for space !!</small>
    {!! Form::select('tag_list[]', $tags,$page->tag_list,['id'=>'tag_list', 'class'=>'form-control', 'multiple']) !!}

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
