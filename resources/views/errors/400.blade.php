@extends('frame')

@section('content')

    Ein Fehler ist aufgetreten: <br/>
    {{$exception->getMessage()}}
    <br/><br/>
    {!! HTML::link(env('HREF_MAIN'), 'Hier gehts zur Startseite') !!} <br/>

@stop
