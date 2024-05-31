<style>
    * {
        font-size: 110%;
        font-family: Arial;
    }

    h1 {
        font-size: 200%;
        font-weight: bold;
    }

    h2 {
        margin-top: 100px;
        font-size: 160%;
        text-decoration: underline;

    }

    h3 {
        margin-top: 50px;
        margin-bottom: 50px;
        font-size: 160%;
    }

</style>

<h1>Anleitung canon.loanout.net</h1>

<h2>1. Anmelden</h2>
@include('manual.1register')

@if ($user='supervisor' || $user='all')
    @include('manual.1activate')
@endif

<h2>2. Ausleihen</h2>
@include('manual.2select')
@include('manual.2loanoptions')
@include('manual.2loaning')

@if ($user='supervisor' || $user='all')
    @include('manual.2block')
@endif

@if ($user='supervisor' || $user='admin' || $user='all')
    <h2>3. Admin</h2>
@endif

@if ($user='admin' || $user='all')
    @include('manual.2repair')
@endif

@if ($user='supervisor' || $user='admin' || $user='all')
    @include('manual.3admin')
@endif