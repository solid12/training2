<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('Products Page') }}</title>

    <!-- Fonts -->

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- Styles -->

</head>
<body>

@if (!session('admin'))
    <div class="alert alert-danger">
        {{ __('You are not logged in !') }}
        {{ die(); }}
    </div>

@endif;

@foreach($products as $products2)

    <ul>
        <img src="{{ $images ? $images[0] : '' }}">
        <li>{{$products2->title }}</li>
        <li>{{$products2->description }}</li>
        <li>{{$products2->price }}</li>
        <a href="/product?id={{$products2->id}}">{{ __('Edit Product') }}</a><br/>
        <a href="/delete?id={{$products2->id}}">{{ __('Delete Product') }}</a>
    </ul>
@endforeach

<a href="/product">{{__('Add Product')}}</a><br/>
<a href="/logout">{{__('Logout')}}</a>



</body>
</html>
