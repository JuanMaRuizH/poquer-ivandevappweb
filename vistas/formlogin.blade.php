@extends('app') 
@section('title') Formulario login
@endsection
 
 
@section('content')
<div class="row justify-content-center" style='margin-top: 50px'>
    <div class="col-md-8">
        <div class="panel panel-default">
            @if (isset($error))
            <div class="alert alert-danger" role="alert">Error Credenciales</div>
            @endif
            <div class="panel-heading">Login</div>
            <div class="panel-body mt-3">
                <form class="form-horizontal validate" method="POST" action="index.php" id='formlogin'>
                    <div class="form-group row">
                        <label for="inputIdentificador" class="col-sm-2 col-form-label">Identificador</label>
                        <div class="col-sm-10">
                            <input type="text" id="inputIdentificador" placeholder="Identificador" name="identificador" required
                            value="{{ (isset($identificador)) ? $identificador : '' }}" title="El identificador no tiene el formato correcto"
                            pattern="[a-z][a-zA-Z0-9]{2,9}"
                                class="form-control col-sm-10">
                            <div class="col-sm-10 invalid-feedback" id="error-for-inputIdentificador"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" id="inputPassword" placeholder="Password" name="clave" required
                            value="{{ (isset($clave)) ? $clave : '' }}" title="La clave no tiene el formato correcto"
                            pattern="\d{8}"
                                class="form-control col-sm-10">
                            <div class="col-sm-10 invalid-feedback" id="error-for-inputPassword"></div>                          
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary" name="botonpetproclogin">
                                Login
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="js/formvalidation.js"></script>
@endsection
