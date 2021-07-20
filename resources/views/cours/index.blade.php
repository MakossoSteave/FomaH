@extends('layouts.app')

@section('content')

@if($cours->isEmpty())

<p>Aucun cours n'existe pour cette formation</p>

@else

@foreach ($cours as $cour)

{{$cour->numero_cours}}

{{$cour->designation}}

{{$cour->image}}

{{$cour->numero_cours}}

{{$cour->nombre_chapitres}}

{{$cour->prix}}

{{$cour->formation_id}}

@endforeach

{{$formations->libelle}}

@endif

@endsection