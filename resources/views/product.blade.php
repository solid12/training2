<!doctype html>
<html lang="{{ app()->getLocale() }}">
@include ('header')

@if (!session('admin'))
    <div class="alert alert-danger">
        {{ __('You are not logged in !') }}
        {{ die() }}
    </div>

@endif;

@if($msg):
<b style="color: white">{{$msg}}</b>
@endif

<div id="login">
    <form method="post" name="login" action="" enctype="multipart/form-data">
        {{ csrf_field() }}
        <label>{{__('Title Product')}}</label><br/>
        <input type="text" name="title" placeholder="{{__('Title Product')}}" value="<?= $title ?>"
               autocomplete="off"/><br/>
        <label>{{__('Description Product')}}</label><br/>
        <input type="text" name="description" placeholder="{{__('Description Product')}}" value="<?= $description ?>"
               autocomplete="off"/><br/>
        <label>{{__('Price Product')}}</label><br/>
        <input type="number" name="price" placeholder="{{__('Price Product')}}" value="<?= $price ?>"
               autocomplete="off"/><br/>
        <label>{{__('Upload')}}</label><br/>
        <input type="file" name="fileToUpload" id="fileToUpload"><br/>
        <input type="submit" class="button" name="submit" value="{{__('Submit')}}">
    </form>
</div>

@include ('footer')