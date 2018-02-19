<!doctype html>
@include ('header')

    @foreach($products as $product):
    <ul>
        <img src="{{ $images ? $images[0] : '' }}">
        <li>{{$product->title }}</li>
        <li>{{$product->description }}</li>
        <li>{{$product->price }}</li>
<a href="/index?id={{$product->id}}">{{ __('Add to Cart') }}</a>
    </ul>
    @endforeach;
<a href="/cart">{{ __('Go Cart') }}</a>

@include ('footer')
