<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>


    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- Styles -->

</head>
<body>

{{__("Hello")}},{{__("your products")}}: <br/>

@foreach($prod as $product)
<ul>
    <img width="120" src="{{$protocol }}{{$_SERVER['HTTP_HOST']}}/{{ $images ? $images[0] : '' }}">
    <li style='padding: 3px'>{{__("Title Product") }}: {{$product->title }}</li>
    <li style='padding: 3px'>{{__("Description Product") }}: {{$product->description }}</li>
    <li style='padding: 3px'>{{__("Price Product") }}: {{$product->price }}</li>
</ul>
@endforeach;

</body>
</html>
