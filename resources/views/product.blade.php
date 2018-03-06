<!doctype html>
<html lang="{{ app()->getLocale() }}">
@include ('header')
@if($msg)
<b style="color: white">{{$msg}}</b><br>
@endif
<div id="login">
    <form method="post" action="" enctype="multipart/form-data">
        {{ csrf_field() }}
        <label>{{__('Title Product')}}</label><br/>
        <input type="text" name="title" placeholder="{{__('Title Product')}}" value="<?= $product->title ?>"
               autocomplete="off"/><br/>
        <label>{{__('Description Product')}}</label><br/>
        <input type="text" name="description" placeholder="{{__('Description Product')}}" value="<?= $product->description ?>"
               autocomplete="off"/><br/>
        <label>{{__('Price Product')}}</label><br/>
        <input type="number" name="price" placeholder="{{__('Price Product')}}" value="<?= $product->price ?>"
               autocomplete="off"/><br/>
        <label>{{__('Upload')}}</label><br/>
        <input type="file" name="fileToUpload" id="fileToUpload"><br/>
        <input type="submit" class="button" name="submit" value="{{__('Submit')}}">
    </form>
</div>

@include ('footer')