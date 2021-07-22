@extends('layouts.app')

@section('content')

@if($cours->isEmpty())

<p>Aucun cours n'existe pour cette formation</p>

@else

{{$cours->numero_cours}}

{{$cours->designation}}

{{$cours->image}}

{{$cours->numero_cours}}

{{$cours->nombre_chapitres}}

{{$cours->prix}}

{{$cours->formation_id}}

@endif

@endsection