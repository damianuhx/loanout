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

    <link href="{{env('HREF_MAIN')}}style.css" type="text/css" rel="stylesheet">



</head>
<body>

<div id="container">

    <div id="mheader" class="mobile">
        <a id="mhome" href="{{env('HREF_MAIN')}}"><img src="/canon_rot.png" alt="Canon" /></a>

        <h1>loan-out</h1>

    </div>

    <div id="header" class="desktop">
        <a id="home" href="{{env('HREF_MAIN')}}"><img src="{{env('HREF_MAIN')}}canon_weiss.png" alt="Canon" /><h1>loan-out</h1></a>
    </div>
</div>
<br/>
<br/>


@yield('content')