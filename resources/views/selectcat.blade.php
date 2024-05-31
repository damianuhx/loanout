
@extends('frame')

@section('content')

<div id="main">

    @foreach($list as $division)
        <br/><h2>{!! HTML::link(env('HREF_MAIN').'division/'.$division['id'], $division['name']) !!} </h2>
            @foreach($division['categories'] as $category)
            <br/><h3>{!! HTML::link(env('HREF_MAIN').'category/'.$category['id'], $category['name']) !!} </h3>
            @foreach($category['types'] as $type)
                        {!! HTML::link(env('HREF_MAIN').'type/'.$type['id'], $type['name']) !!} <br/>
                  @foreach($type['objects'] as $object)
                            <em>....{!! HTML::link(env('HREF_MAIN').'object/'.$object['id'], $object['name']) !!}</em> <br/>
                    @endforeach
                @endforeach
            @endforeach
        <br/>
    @endforeach


</div>

@stop

