<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Canon loan-out</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="{{env('HREF_MAIN')}}jquery-1.12.1.js"></script>
    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="{{env('HREF_MAIN')}}fancybox/jquery.fancybox.css" type="text/css" media="screen" />
    <script type="text/javascript" src="{{env('HREF_MAIN')}}fancybox/jquery.fancybox.pack.js"></script>
    <script type="text/javascript" src="{{env('HREF_MAIN')}}stupidtable.min.js"></script>

    <link href="{{env('HREF_MAIN')}}style.css" type="text/css" rel="stylesheet">

    <script type="text/javascript">
        $(document).ready(function(){
            var menu = $('#mnav')
            $('#mmenu').click(function(event){
                event.preventDefault();
                if (menu.is(":visible"))
                {
                    menu.slideUp(100);
                    $(this).removeClass("open");
                }
                else
                {
                    menu.slideDown(100);
                    $(this).addClass("open");
                }
            });
        $("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
            $(".fancybox").fancybox({
                maxWidth	: 800,
                maxHeight	: 600,
                fitToView	: false,
                width		: '100%',
                height		: '100%',
                autoSize	: false,
                closeClick	: false,
                openEffect	: 'none',
                closeEffect	: 'none'
            });
        $("table").stupidtable();
        });
    </script>

</head>
<body>

<?php
if (!isset($language)){
    $language='de';
}
$t=config('app.translations');
foreach ($t as $key=>$value)
{
    $t[$key]=$value[$language];
}
?>

<div id="container">
    @if(!isset($current))
        <?php $current='none';?>
    @endif

    <div id="mheader" class="mobile">
        <a id="mhome" href="{{env('HREF_MAIN')}}"><img src="/canon_rot.png" alt="Canon" /></a>
        <a id="mmenu" href="{{env('HREF_MAIN')}}"><img src="/toggle.png" alt="Menu" /></a>
        <h1>loan-out</h1>
        <div id="mnav">
            <a @if($current=='browser') class="current" @endif href="{{env('HREF_MAIN')}}">{{ucfirst($t['browser'])}}</a>
            <a @if($current=='lending') class="current" @endif href="{{env('HREF_MAIN')}}grant/all">{{ucfirst($t['lending'])}}</a>
            <a @if($current=='admin') class="current" @endif href="{{env('HREF_MAIN')}}admin">{{ucfirst($t['options'])}}</a>
            <a href="{{env('HREF_MAIN')}}auth/logout">{{ucfirst($t['logout'])}}</a>
        </div>
    </div>

    <div id="header" class="desktop">
        <a id="home" href="{{env('HREF_MAIN')}}"><img src="{{env('HREF_MAIN')}}canon_weiss.png" alt="Canon" /><h1>loan-out</h1></a>
        <div id="nav">
            <a @if($current=='browser') class="current" @endif href="{{env('HREF_MAIN')}}">{{ucfirst($t['browser'])}}</a>
            <a @if($current=='lending') class="current" @endif href="{{env('HREF_MAIN')}}grant/all">{{ucfirst($t['lending'])}}</a>
            <a @if($current=='admin') class="current" @endif href="{{env('HREF_MAIN')}}admin">{{ucfirst($t['options'])}}</a>
            <a href="{{env('HREF_MAIN')}}auth/logout">{{ucfirst($t['logout'])}}</a>
        </div>
    </div>


    @if (isset($subcurrent))
    @if (in_array($subcurrent, ['divisions', 'categories', 'types', 'objects', 'basket', 'locked']))
        <div id="meta">
            <h1>{{$t['browser']}}</h1>
            <div class="subnav">

                @foreach($divisions as $area)

                <a href="{{env('HREF_MAIN')}}categories/{{$area['id']}}"
                @if($division['name'] == $area['name']) class="current" @endif
                >{{ucfirst($area['name_'.$language])}}</a>

                    <?php //var_dump($division) ?>
                @endforeach

                <a href="{{env('HREF_MAIN')}}basket"
                @if($subcurrent=='basket') class="current" @endif
                >{{ucfirst($t['basket'])}}</a>

                @if($user_type=='supervisor')
                <a href="{{env('HREF_MAIN')}}lock"
                @if($subcurrent=='locked') class="current" @endif
                        >{{ucfirst($t['locked'])}}</a>
                @endif
            </div>
        </div>
    @endif

    @if (in_array($subcurrent, ['search', 'requested', 'granted', 'handed', 'restocked', 'returned', 'confirmation']))
	
<div id="meta">

<h1>Ausleihe</h1>

	<div class="subnav">

        <a href="{{env('HREF_MAIN')}}grant/all"
        @if($subcurrent=='requested') class="current" @endif
                >{{ucfirst($t['grant'])}}</a>

        <a href="{{env('HREF_MAIN')}}handout/all"
        @if($subcurrent=='granted') class="current" @endif
                >{{ucfirst($t['hand'])}}</a>

        <a href="{{env('HREF_MAIN')}}restock/all"
        @if($subcurrent=='handed') class="current" @endif
                >{{ucfirst($t['restock'])}}</a>

	</div>

</div>

    @endif


        @if (in_array($subcurrent, ['none', 'accessory', 'accessoryset', 'category', 'type', 'object', 'location', 'source', 'user', 'customer', 'division']))

		<div id="meta">
		
			<h1>{{$t['options']}}</h1>

			<div class="subnav">

                @if($user_type=='supervisor')

                    <a href="{{env('HREF_MAIN')}}user/all"
                    @if($subcurrent=='user') class="current" @endif
                            >Users</a>


            <a href="{{env('HREF_MAIN')}}source/all"
            @if($subcurrent=='source') class="current" @endif
                    >Sources</a>

                    <a href="{{env('HREF_MAIN')}}division/all"
                    @if($subcurrent=='division') class="current" @endif
                            >Divisions</a>
                @endif

                    @if($user_type=='admin' || $user_type=='supervisor')
                        <a href="{{env('HREF_MAIN')}}category/all"
                        @if($subcurrent=='category') class="current" @endif
                                >Categories</a>

                        <a href="{{env('HREF_MAIN')}}type/all"
                        @if($subcurrent=='type') class="current" @endif
                                >Types</a>

                        <a href="{{env('HREF_MAIN')}}object/all"
                        @if($subcurrent=='object') class="current" @endif
                                >Objects</a>

                        <a href="{{env('HREF_MAIN')}}accessory/all"
                        @if($subcurrent=='accessory') class="current" @endif
                                >Accessories</a>

                        <a href="{{env('HREF_MAIN')}}accessoryset/all"
                        @if($subcurrent=='accessoryset') class="current" @endif
                                >Accessorysets</a>

                        <a href="{{env('HREF_MAIN')}}location/all"
                        @if($subcurrent=='location') class="current" @endif
                                >Locations</a>

                        <a href="{{env('HREF_MAIN')}}cat/all"
                        @if($subcurrent=='location') class="current" @endif
                                >Structured</a>

                    @endif


            <a href="{{env('HREF_MAIN')}}customer/all"
            @if($subcurrent=='customer') class="current" @endif
                    >Customers</a>
			</div>
		</div>

        @endif
    @endif


    @yield('content')


</div>

</body>
</html>
