
@extends('frame')

@section('content')

<div id="main" class="details">

    <?php $t=config('app.translations');?>

        <script>
            $(function(){

                // jQuery UI Dialog

                $('#jq-dialog').dialog({
                    autoOpen: false,
                    width: 400,
                    modal: true,
                    resizable: false,
                    buttons: {
                        "Submit Form": function() {
                            document.testconfirmJQ.submit();
                        },
                        "Cancel": function() {
                            $(this).dialog("close");
                        }
                    }
                });

                $('form#testconfirmJQ').submit(function(e){
                    e.preventDefault();
                    $("span#dialog-email strong").html($("input#emailJQ").val());
                    $('#jq-dialog').dialog('open');
                });
            });
        </script>


    <h2>{{ucfirst($t[$purpose][$language])}}</h2>
        @if ($purpose!=='request')
            ID: {{$lent['id']}}<br/><br/>
        @endif



        {!!  Form::open(['url'=>$purpose.'/'.$lent['id'], 'method'=>'post', 'id'=>'testconfirmJS', 'name'=>'testconfirmJS']) !!}
        <div class="subdetails">

        @if($purpose=='confirmation')
            <h2>{{$lent['state']['name_'.$language]}}</h2>
        @endif


            <h3>{{$t['objects'][$language]}}</h3>
            <ul>
                @foreach($lent['objects'] as $object)
                    <li><b>{{$object['type']['name']}} ({{$object['name']}})</b>

                        @if($purpose=='request' || $purpose=='grant')
                            {!! HTML::link('reservex/'.$object['id'], 'remove') !!} <br/>
                        @elseif($purpose=='handout')
                            {{$object['location']['name']}}
                        @elseif($purpose=='restock')
                            {!!Form::hidden('object_'.$object['id'], 1) !!}
                            </br>
                            {!!Form::hidden('working_'.$object['id'], 0) !!}
                            {!! Form::checkbox('working_'.$object['id'], 1); !!}
                            <em>{{$t['working'][$language]}}</em>
                            </br><em>accessories:</em>
                            @foreach ($object['accessories'] as $accessory)

                                @if ($accessory['included'])
                                    <p style="color:green">x
                                @else
                                    <p style="color:red">o
                                @endif
                                        {!!Form::hidden('accessory_'.$object['id'].'_'.$accessory['id'], 0) !!}
                                        {!! Form::checkbox('accessory_'.$object['id'].'_'.$accessory['id'], 1); !!}
                                {{$accessory['name_'.$language]}}
                                @if ($accessory['required']==false)
                                    ({{$t['optional'][$language]}})
                                    @endif
                                    </p>
                            @endforeach
                            <br/>
                        @endif

                    </li>
                @endforeach
                    @if ($purpose=='request')
                    <li>
                    <a href="{{env('HREF_MAIN')}}categories">{{$t['add_object'][$language]}}</a>
                    </li>
                    @endif
            </ul>


            <h3>{{$t['user'][$language]}}</h3>
        {{$lent['user']['name']}} <br/>
        {{$lent['user']['email']}}



        <h3>{{$t['customer'][$language]}}</h3>
        @if ($purpose == 'request')
            <?php $customers[0]='new';?>
            {!! Form::select('customer_id', $customers, null, ['id'=>'customer', 'title'=>'Bitte wählen Sie einen vordefinierten Reseller aus oder wählen Sie "new" um eine eigene Adresse einzugeben']) !!} <br/>
            <div id="customer_form"></div>
        @else
            {{$lent['customer']['name']}}<br/>
            {{$lent['customer']['company']}}<br/>
            {{$lent['customer']['title']}}<br/>
            {{$lent['customer']['first_name']}}
            {{$lent['customer']['last_name']}}<br/>
            {{$lent['customer']['street']}}
            {{$lent['customer']['number']}}<br/>
            {{$lent['customer']['zip']}}
            {{$lent['customer']['city']}}<br/>
            {{$lent['customer']['country']}}<br/>
            {{$lent['customer']['phone']}}<br/>
            {{$lent['customer']['email']}}<br/>
        @endif

            <script>
                function myFunction(){
                    $('#customer_form').append('<input type="text"/>');
                }

                $('#customer').change(function(){
                    var value = $(this).find('option:selected').attr('value');
                    if (value==0)
                    {
                        var myNode = document.getElementById("customer_form");
                        while (myNode.firstChild) {
                            myNode.removeChild(myNode.firstChild);
                        }
                        $('#customer_form').append('<div>{{ucfirst($t['company'][$language])}}:</div>');
                        $('#customer_form').append('<input name="company" type="text"/>');
                        $('#customer_form').append('{{ucfirst($t['title'][$language])}}:');
                        $('#customer_form').append('<input name="title" type="text" />');
                        $('#customer_form').append('{{ucfirst($t['first_name'][$language])}}:');
                        $('#customer_form').append('<input name="first_name" type="text" required/>');
                        $('#customer_form').append('{{ucfirst($t['last_name'][$language])}}:');
                        $('#customer_form').append('<input name="last_name" type="text" required/>');
                        $('#customer_form').append('{{ucfirst($t['addition'][$language])}}:');
                        $('#customer_form').append('<input name="addition" type="text"/>');
                        $('#customer_form').append('{{ucfirst($t['street'][$language])}}:');
                        $('#customer_form').append('<input name="street" type="text" required/>');
                        $('#customer_form').append('{{ucfirst($t['number'][$language])}}:');
                        $('#customer_form').append('<input name="number" type="text"/>');
                        $('#customer_form').append('{{ucfirst($t['zip'][$language])}}:');
                        $('#customer_form').append('<input name="zip" type="text" required/>');
                        $('#customer_form').append('{{ucfirst($t['city'][$language])}}:');
                        $('#customer_form').append('<input name="city" type="text" required/>');
                        $('#customer_form').append('{{ucfirst($t['country'][$language])}}:');
                        $('#customer_form').append('<input name="country" type="text"/>');
                        $('#customer_form').append('{{ucfirst($t['phone'][$language])}}:');
                        $('#customer_form').append('<input name="phone" type="text"/>');
                        $('#customer_form').append('{{ucfirst($t['email'][$language])}}:');
                        $('#customer_form').append('<input name="email" type="text"/>');
                        $('#customer_form').append('{{ucfirst($t['language'][$language])}}:');
                        $('#customer_form').append('{!! Form::select("language", ["de"=>$t["german"][$language], "fr"=>$t["french"][$language], "en"=>$t["english"][$language]]) !!}');
                    }
                    else if (value>0)
                    {
                        var myNode = document.getElementById("customer_form");
                        while (myNode.firstChild) {
                            myNode.removeChild(myNode.firstChild);
                        }
                    }
                });
            </script>


        <h3>{{$t['dates'][$language]}}</h3>
        {{$t['return_date'][$language]}}<br/>

        @if($purpose=='request' || $purpose=='grant')
            <input type="date" value="{{$lent['return_at']}}" name="return_at" id="datepicker" required> <br/>
        @else
            {{$lent['return_at']}}
        @endif



        <h3>{{$t['purpose'][$language]}}</h3>

        @if($purpose=='request')
                <input type="text" name='purpose'"></input> <br/>
        @else
                {{$lent['purpose']}}<br/>
        @endif



        <h3>{{ucfirst($t['shipping'][$language])}}</h3>

            @if($purpose=='request')

                {!!Form::radio('shipping', '1') !!}
                {{$t['send'][$language]}}
                <br/>
                {!!Form::radio('shipping', '0', true) !!}
                {{$t['pickup'][$language]}}
            @else
                {{$t[$lent['shipping']][$language]}}
            @endif
            <br/><br/>


        @if($purpose=='restock')
            <h3>{{$t['handed'][$language]}}</h3>
            {{$lent['handed_at']}}
        @endif

        @if(false)
            <h3>{{$t['restocked'][$language]}}</h3>
            {{$lent['stored_at']}}
        @endif

    </div>

        @if($purpose!=='confirmation')
            <input class="btn btn-primary" id="submitJS" name="submitJS" type="submit" value="{{$t[$purpose][$language]}}" onClick="return confirm('{{$t['are_you_sure'][$language]}}')" />
        @endif

    <br/>

        {!!  Form::close() !!}

        @if($purpose=='grant')
            <br/>
        {!!  Form::open(['url'=>'reject/'.$lent['id'], 'method'=>'post']) !!}

            <input class="btn btn-primary" id="submitJS" name="submitJS" type="submit" value="{{$t['reject'][$language]}}" onClick="return confirm('{{$t['are_you_sure'][$language]}}')" />

        {!!  Form::close() !!}
        @endif





        <br/>
    @if($purpose!=='request')
        {!!  Form::open(['url'=>'print/'.$lent['id'], 'method'=>'get']) !!}
        {!! Form::submit('print') !!}
        {!!  Form::close() !!}
    @endif

<div class="clear"></div>


@stop

</div>