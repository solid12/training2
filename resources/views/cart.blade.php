<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('Cart Page') }}</title>

    <!-- Fonts -->

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- Styles -->

</head>
<body>

@foreach($prod as $product)
<ul>
    <img src="{{ $images ? $images[0] : '' }}">
    <li>{{$product->title }}</li>
    <li>{{$product->description }}</li>
    <li>{{$product->price }}</li>
    <a href="/cart?id={{$product->id}}">{{__('Delete Product')}}</a>
</ul>
@endforeach;

<br/>
<br/>
<form style="padding: 120px 30px" action="" method="post" name="cart">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="name" name="name" placeholder="{{ __("Name") }}" autocomplete="off" required="required"/>
    <input type="email" name="contact" placeholder="{{ __("Contact Details") }}" autocomplete="off"
           required="required"/>
    <textarea rows="4" cols="30" name="comment" form="cart">{{ __("Comments") }}</textarea>
    <input type="submit" name="send" class="btn btn-success pull-right" value="{{ __("Checkout") }}"> </input>
</form>

<a href="/index">{{ __('Go Home') }}</a>
</body>
</html>
