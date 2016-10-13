{!! Form::open(
    array(
        'url' => '/admin/import',
        'method' => 'post',
        'class' => 'form',
        'novalidate' => 'novalidate',
        'files' => true)) !!}

<div class="form-group">
    <div class="input-group">
        <label class="btn btn-primary btn-icon-text waves-effect btn-file" title="Upload">
            <i class="zmdi zmdi-upload" ></i>
            <span class="hidden-xs">Upload .txt File</span>
            {!! Form::file('posts', null, ['class'=> 'hidden']) !!}
        </label>

    </div>

    <div class="form-group" style="margin:0px 15px;">
        <div class="input-group">
            {!! Form::text('Delimiter', null, ['placeholder' => 'delimiter', 'class' => 'form-control']) !!}
        </div>
    </div>

    <div class="form-group">
        <div class="input-group">
            {!! Form::submit('Import Posts') !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>