<!doctype html>
<html lang="{{ app()->getLocale() }}">
@include ('header')

@if (session('admin'))
    <div class="alert alert-danger">
        {{__('You are already logged in !')}}
        {{ die() }}
        <meta http-equiv="refresh" content="3; url=/products" />

    </div>

@endif;

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">{{__('Login')}}</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('user') ? ' has-error' : '' }}">
                                <label for="user" class="col-md-4 control-label">{{__('Username')}}</label>

                                <div class="col-md-12">
                                    <input id="user" type="name" class="form-control" name="user" placeholder="{{__('User')}}" value="{{ old('user') }}" required autofocus>

                                    @if ($errors->has('user'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('user') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">{{__('Password')}}</label>

                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control" placeholder="{{__('Password')}}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <input type="submit" name="submit" value="{{__('Submit')}}">

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@include ('footer')