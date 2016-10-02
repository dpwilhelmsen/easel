{!! Form::open(
    array(
        'url' => '/admin/import',
        'method' => 'post',
        'class' => 'form',
        'novalidate' => 'novalidate',
        'files' => true)) !!}

<div class="form-group">
    {!! Form::label('Posts TXT File') !!}
    {!! Form::file('posts', null) !!}
</div>

<div class="form-group">
    {!! Form::label('Delimiter') !!}
    {!! Form::text('delimiter', null) !!}
</div>

<div class="form-group">
    {!! Form::submit('Import Posts') !!}
</div>
{!! Form::close() !!}
</div>