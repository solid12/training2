<!doctype html>
<html lang="{{ app()->getLocale() }}">
@include ('header')

{{__("Hello")}},{{__("your products")}}: <br/>

@foreach($products as $product)
<ul>
    <img width="120" src="{{$protocol }}{{$_SERVER['HTTP_HOST']}}/{{ $images ? $images[0] : '' }}">
    <li style='padding: 3px'>{{__("Title Product") }}: {{$product->title }}</li>
    <li style='padding: 3px'>{{__("Description Product") }}: {{$product->description }}</li>
    <li style='padding: 3px'>{{__("Price Product") }}: {{$product->price }}</li>
</ul>
@endforeach;

@include ('footer')
