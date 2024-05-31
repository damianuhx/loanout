<html>
<head>
<link href="{{env('HREF_MAIN')}}style.css" type="text/css" rel="stylesheet">
</head>
<body class="fancy">

<div id="overlay">

	<div class="details">
    <?php
        $t=config('app.translations');
        foreach ($t as $key=>$value)
        {
            $t[$key]=$value[$language];
        }
    ?>

    <h2>{{ucfirst($t['objectdetails'])}}</h2>

    {{ucfirst($t['name'])}}: {{$object['name']}} <br/>
    <br/>
    {{ucfirst($t['available'])}}: {{$t[$object['available']]}}
        @if (!$object['available'])
            ({{ucfirst($t['return_date'])}}:{{$object['return_date']}} | {{$lender}})
        @endif
        <br/>



        {{ucfirst($t['locked'])}}: {{$t[$locked]}}
        @if ($object['locked'])
              | {{$locker}}
        @endif
        <br/>
    {{ucfirst($t['working'])}}: {{$t[$object['working']]}}<br/>
    {{ucfirst($t['complete'])}}: {{$t[$object['complete']]}}<br/>
    <br/>
    {{ucfirst($t['accessories'])}}:<br/>
    @foreach ($object['accessories'] as $accessory)
            @if ($accessory['included'])
                <p style="color:green">x
                @else
                <p style="color:red">o
            @endif
                {{$accessory['name_'.$language]}}
                </p>
    @endforeach
	</div>

    @if ($object['available'] || $object['locked']==$user['id'])
    <a href="{{env('HREF_MAIN').'reserve/'.$object['id']}}" target="_parent" class="button">{{ucfirst($t['add'])}}</a>
    @endif

    @if ($user['type']=='supervisor')
        <br/>
        @if ($object['locked']==$user['id'])
            <a href="{{env('HREF_MAIN')}}unlock/{{$object['id']}}" target="_parent" class="button" id="submitJS" name="submitJS" type="submit" value="{{$t['unlock']}}" onClick="return confirm('{{$t['are_you_sure']}}')">{{$t['unlock']}}</a>
        @elseif (!$object['locked']>0)
            <a href="{{env('HREF_MAIN')}}lock/{{$object['id']}}" target="_parent" class="button" id="submitJS" name="submitJS" type="submit" value="{{$t['lock']}}" onClick="return confirm('{{$t['are_you_sure_lock']}}')">{{$t['lock']}}</a>
        @else
            Das Objekt ist bereits blockiert von user_id {{$object['locked']}}
        @endif
    @endif



</div>

</body>
</html>