
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

        <h1>{{$t['objects']}}</h1>
        <table border="1" style="width:100%">
            <thead>
            <tr>
                <th class="nomobile" data-sort="string">{{ucfirst($t['division'])}}</th>
                <th data-sort="string">{{ucfirst($t['category'])}}</th>
                <th data-sort="string">{{ucfirst($t['model'])}}</th>
                <th data-sort="string">{{ucfirst($t['object'])}}</th>
                <th data-sort="string">{{ucfirst($t['available'])}}</th>
                <th class="nomobile" data-sort="string">{{ucfirst($t['complete'])}}</th>
                <th class="nomobile" data-sort="string">{{ucfirst($t['working'])}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($objects as $object)
                <tr>
                    <td class="nomobile">{{$object['type']['category']['division']['name']}}</td>
                    <td>{{$object['type']['category']['name']}}</td>
                    <td>{{$object['type']['name']}}</td>
                    <td>{!! HTML::link( env('HREF_MAIN').'details/'.$object['id'], $object['name'], array('data-fancybox-type' => 'iframe', 'class' => 'fancybox')) !!}</td>
                    <td >{{$t[$object['available']]}}
                    @if(!$object['available'])
                    ({{$object['return_date']}})
                    @endif
                    </td>
                    <td class="nomobile">{{$t[$object['complete']]}}</td>
                    <td class="nomobile">{{$t[$object['working']]}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

@stop