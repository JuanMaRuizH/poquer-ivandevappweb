@extends('app') 
@section('topright')
<div class="d-flex dropdown p-2">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
            {{ $poker->getJugador1()->getIdentificador() }} 
        </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="index.php?botonpetlogout">Logout</a>
    </div>
</div>
@endsection
 
@section('content')

<div class="d-flex flex-column">
    <div class="h4 mt-5"> Tus cartas son:</div>

    <div class="d-flex  mb-5">
        @foreach ($poker->getJugador1()->getJugada() as $carta)
        <img class="m-10" src="{{ " img/" . $carta->getPalo() . "/" . $carta->getValor() . $carta->getPalo()[0] . ".svg" }}" alt="Card image cap">        
        @endforeach
    </div>
</div>

<div class="d-flex flex-column">
    <div class="h4 mt-5"> Las cartas de la banca son:</div>

    <div class="d-flex mb-5">
        @foreach ($poker->getJugador2()->getJugada() as $carta)
        <img class="m-10" src="{{ " img/" . $carta->getPalo() . "/" . $carta->getValor() . $carta->getPalo()[0] . ".svg" }}" alt="Card image cap">        
        @endforeach
    </div>
</div>
@endsection
 
@section('mensaje') 

@if($victoria)
<div class="d-flex  flex-column">
    <div class="h4"> Has Ganado!!</div>
</div>
@else
<div class="d-flex  flex-column">
    <div class="h4"> Has perdido!!</div>
</div>
@endif
<ul class="nav navbar-nav">
    <li>
        <a class="nav-item active" href="index.php?botonvolverajugar">Nueva Partida</a>
    </li>
</ul>

@endsection