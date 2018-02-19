<!doctype html>
<html lang="{{ app()->getLocale() }}">
@include ('header')

@foreach($products as $product)
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
@include ('footer')
