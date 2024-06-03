
@extends('frame')

@section('content')

    <?php
    $t=config('app.translations');
    foreach ($t as $key=>$value)
    {
        $t[$key]=$value[$language];
    }
    ?>

<div id="main">

    <h1>{{ucfirst($t[$action])}}</h1>
    <table border="1" style="width:100%">
	<thead>
	<tr>
        <th data-sort="int">Grant</th>
        <th class="nomobile" data-sort="string">{{ucfirst($t['objects'])}}</th>
        <th data-sort="string">{{ucfirst($t['customer'])}}</th>
        <th data-sort="string">{{ucfirst($t['user'])}}</th>
        <th class="nomobile" data-sort="string">{{ucfirst($t['state'])}}</th>
        <th class="nomobile" data-sort="float">{{ucfirst($t['purpose'])}}</th>
        <th data-sort="float">{{ucfirst($t['updated'])}}</th>
        <th class="nomobile" data-sort="float">{{ucfirst($t['reserved'])}}</th>
        <th class="nomobile" data-sort="float">{{ucfirst($t['granted'])}}</th>
        <th class="nomobile" data-sort="float">{{ucfirst($t['handed'])}}</th>
        <th class="nomobile" data-sort="float">{{ucfirst($t['return_until'])}}</th>
	</tr>
	</thead>
	<tbody>
        @foreach($lents as $lent)
            <tr>
                <td>{!! HTML::link($action.'/'.$lent['id']) !!}</td>
                <td class="nomobile">
                    @foreach ($lent['objects'] as $object)
                        {{$object['type']['name']}} ({{$object['name']}}),
                    @endforeach
                </td>
                <td>{{$lent['customer']['name']}}</td>
                <td>{{$lent['user']['name']}}</td>
                <td class="nomobile">{{$lent['state']['name']}}</td>
                <td class="nomobile">{{$lent['purpose']}}</td>
                <td>{{$lent['updated_at']}}</td>
                <td class="nomobile">{{$lent['reserved_at']}}</td>
                <td class="nomobile">{{$lent['granted_at']}}</td>
                <td class="nomobile">{{$lent['handed_at']}}</td>
                <td class="nomobile">{{$lent['return_at']}}</td>
            </tr>
        @endforeach
	</tbody>
    </table>

</div>

@stop