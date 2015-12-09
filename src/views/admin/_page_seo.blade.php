

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

    {!! Form::text('page[og_descr]',$page->open_graph,['class'=>'form-control'] ) !!}
</div>


