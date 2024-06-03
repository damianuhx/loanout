


@extends('frame')

@section('content')

<div id="main">

    {!! Form::open(['url'=>'lent/all', 'method'=>'get']) !!}

    @foreach(['user'=>$user, 'customer'=>$customer, 'state'=>$state] as $key=>$array)
        {!! Form::label($key) !!}
        {!! Form::select($key, $array) !!}
        <br/>
    @endforeach

    @foreach(['updated', 'reserved', 'granted', 'handed', 'returned', 'return'] as $field)
        {!! Form::label($field.'_at') !!}
        {!! Form::select($field.'_sign', ['none'=>'egal', 'before'=>'kleiner als', 'equal'=>'gleich', 'after'=>'grösser als']) !!}
        <input type="text" value="" name="{{$field.'_at'}}" id="datepicker"> <br/>
        <br/>
    @endforeach

    {!! Form::submit('search') !!}
    {!! Form::close() !!}

</div>
@stop