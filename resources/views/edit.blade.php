@extends('frame')

@section('content')

<div id="main" class="edit">

    <h2>{{$title}}</h2>
    {!!  Form::open(['url'=>$link]) !!}

    <div class="form-group" >

        @if ($id=='new')
            {!! Form::submit('create') !!}
        @else
            {!! Form::submit('update') !!}
        @endif
    </div>
    <br/>
    @foreach ($fields as $field)
        <div class="form-group">
            {!! Form::label($field['label']) !!}
            @if ($field['type']=='name')
                {!! Form::text($field['name'], $field['content']) !!}
            @elseif ($field['type']=='text')
                {!! Form::textarea($field['name'], $field['content']) !!}
            @elseif ($field['type']=='decimal')
                <input type="number" name="{{$field['name']}}" step="0.01" value="{{$field['content']}}"/>
            @elseif ($field['type']=='number')
                {!! Form::input('number', $field['name'], $field['content']) !!}
            @elseif ($field['type']=='date')
                {!! Form::input('date', $field['name']) !!}
            @elseif ($field['type']=='hidden')
                {{$field['content']}}
            @elseif ($field['type']=='check')
                {!!Form::hidden($field['name'], 0) !!}
                {!! Form::checkbox($field['name'], 1); !!}
            @elseif ($field['type']=='timestamp')
                {{$field['content']}}
            @elseif ($field['type']=='dropdown')
                {!! Form::select($field['name'], $field['selection'], $field['content']) !!}
            @elseif ($field['type']=='tomany')
            @else
                {{$field['content']}}
                {!!Form::hidden($field['name'], $field['content']) !!}
            @endif
        </div>
    @endforeach
    <br/>
    {!!  Form::close() !!}

    @if($id!=='new')

		{!! Form::open(array('url' => $link, 'method' => 'delete')) !!}
        {!! Form::submit('delete') !!}
        {!! Form::close() !!}

<div class="clear"></div>

        @foreach ($fields as $field)
            @if ($field['type']=='tomany')

<div class="tomany">
                <h2>{{$field['name']}}</h2>

				<div class="small-buttons">
                @foreach($field['fentries'] as $fkey=>$fentry)
                        {!! Form::open(array('url' => $link.'/'.$field['name'].'/'.$fentry['id'], 'method' => 'delete')) !!}
                        {{$fentry['name']}}{!! Form::submit('remove') !!}
                    {!!  Form::close() !!}
                @endforeach

                {!! Form::open(array('url' => $link.'/'.$field['name'], 'method' => 'post')) !!}
                {!! Form::select('id', $field['selection']) !!}
                {!! Form::submit('add') !!}
                {!!  Form::close() !!}
				</div>

				<div class="clear"></div>

</div>

            @endif
        @endforeach

    @endif

<div class="clear"></div>

</div>

@stop

