
@extends('frame')

@section('content')

<div id="main">

    <?php
    $t=config('app.translations');
    foreach ($t as $key=>$value)
    {
        $t[$key]=$value[$language];
    }
    ?>

	<div id="absender">
    <strong>Canon (Schweiz) AG</strong> <br/>
    CIG Marketing Camera <br/>
    Richtistrasse 9 <br/>
    8304 Wallisellen <br/>
    Tel: 044 835 61 61 <br/>
    Email: cps{{'@'}}canon.ch <br/>
    www.canon.ch <br/>
    <br/>
    Dietlikon, {{date('d.m.Y')}} </br>
	</div>

	<div id="adresse">
    <b>EINSCHREIBEN</b><br/>
    {{$lent['customer']['company']}}<br/>
    {{$lent['customer']['title']}}<br/>
    {{$lent['customer']['first_name']}}
    {{$lent['customer']['last_name']}}<br/>
    {{$lent['customer']['street']}}
    {{$lent['customer']['number']}}<br/>
    {{$lent['customer']['zip']}}
    {{$lent['customer']['city']}}<br/>
    {{$lent['customer']['country']}}<br/><br/>
	</div>

	<div id="lieferung">
    <h1>Leihlieferung</h1>
    <p>Sehr geehrter Kunde</p>

    {{ucfirst($t['you_get_until'])}} {{date('d.m.Y', strtotime($lent['return_at']))}}:

    <ul>
        @foreach($lent['objects'] as $object)
            <li>{{$object['type']['name']}} ({{$object['name']}})</li>
        @endforeach
    </ul>

    <p>Diese Ausleihe im Wert von CHF {{$totalfee}} wird Ihnen offeriert von Canon. Verspätet retournierte Ware wird mit CHF {{$fee}} pro Tag in Rechnung gestellt.</p>
    <p>Bei Schäden oder Verlust der Ware übernehmen wir keine Haftung. Bitte retournieren Sie die Ware an folgende Adresse:</p>

	<p>
    Canon (Schweiz) AG <br/>
    CIG Marketing Camera <br/>
    Richtistrasse 9 <br/>
    8304 Wallisellen
	</p>

	<p>Für allfällige Fragen stehen wir Ihnen gerne zur Verfügung.</p>

<br/>

    <p>Mit freundlichen Grüssen</p>

    <p>
	Canon (Schweiz) AG<br/>
    Marketing CIG<br/>
    Peter Stijnman
	</p>
	</div>

</div>

@stop