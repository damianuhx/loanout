
@extends('frame')

@section('content')

<div id="main">

@if ($subcurrent!=='none')
    {!! HTML::link(env('HREF_MAIN').$title.'/new', 'new', array('class' => 'button')) !!} <br/>

    @foreach($list as $entry)
        {!! HTML::link(env('HREF_MAIN').$title.'/'.$entry['id'], $entry['name']) !!} <br/>
    @endforeach

@endif

</div>

@stop

