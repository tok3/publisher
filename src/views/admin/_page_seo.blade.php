

<div class="form-group">
    {!! Form::label('page[meta_description]', 'meta_description:') !!}

    {!! Form::text('page[meta_description]',$page->meta_description,['class'=>'form-control'] ) !!}
</div>

<div class="form-group">
    {!! Form::label('page[meta_keywords]', 'meta_keywords:') !!}

    {!! Form::text('page[meta_keywords]',$page->meta_keywords,['class'=>'form-control'] ) !!}
</div>


<div class="form-group">
    {!! Form::label('page[og_descr]', 'Open Graph, Description:') !!}

    {!! Form::text('page[og_descr]',$page->og_descr,['class'=>'form-control'] ) !!}
</div>
<div class="form-group">
    {!! Form::label('page[add_head_data]', 'Additional Head data:') !!}

    {!! Form::textarea('page[add_head_data]',$page->add_head_data,['class'=>'form-control'] ) !!}
</div>


