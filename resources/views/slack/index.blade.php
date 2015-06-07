@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 panel panel-default">

                @if(session()->has('messages'))
                    <div class="alert alert-success">

                        <a href="#" class="close" data-dismiss="alert">&times;</a>

                        <strong>{{session('messages')}}</strong>

                    </div>
                @endif


                    <h1 class="margin-base-vertical">Unete al Canal #laraveles en Slack</h1>

                <p>
                    Llena el formulario y recibe una invitación para ser parte de la
                    comunidad.
                </p>

                <p>
                    En este momento se encuentran <strong>{{$stats['actives']}}</strong> integrantes en linea de <strong>{{$stats['total']}}</strong>
                </p>

                <form class="margin-base-vertical" method="post" action="{{route('invite')}}">
                    <div class="form-group">
                        <input class="form-control input-lg" name="nombre" type="text" placeholder="Nombre" value="{{old('nombre')}}"/>
                        <span class="text-danger">{{$errors->first('nombre')}}</span>
                    </div>
                    <div class="form-group">
                        <input class="form-control input-lg" name="apellido" type="text" placeholder="Apellidos" value="{{old('apellido')}}"/>
                        <span class="text-danger">{{$errors->first('apellido')}}</span>

                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                        <input type="text" class="form-control input-lg" name="email" placeholder="username@domain.com" value="{{old('email')}}"/>
                    </div>
                    <span class="text-danger">{{$errors->first('email')}}</span>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <p class="help-block text-center"><small>No mantenemos información de tus cuentas</small></p>
                    <p class="text-center">
                        <button type="submit" class="btn btn-success btn-lg">Unirme</button>
                    </p>
                </form>

            </div><!-- //main content -->
        </div><!-- //row -->
    </div> <!-- //container -->
@endsection