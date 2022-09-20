<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>System wejść i wyjść klientów w galerii</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script type="text/javascript" src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
<div id="title">
    System wejść i wyjść klientów w galerii
</div>
<div id="menu-container">
    <ul id="menu">
        <li><a href="/"@if (Request::path() == '/') class="active"@endif>Strona główna</a></li>
        <li><a href="zlicz-losowo-wejscia-wyjscia"@if (Request::path() == 'zlicz-losowo-wejscia-wyjscia') class="active"@endif>Zlicz losowo wejścia i wyjścia - cron</a></li>
        <li><a href="wykres-statystyki"@if (Request::path() == 'wykres-statystyki') class="active"@endif>Wykres i statystyki</a></li>
    </ul>
</div>
<div id="content">
