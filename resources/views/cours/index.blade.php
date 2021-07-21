@extends('layouts.app')

@section('content')

@if($cours->isEmpty())

<p>Aucun cours n'existe pour cette formation</p>

@else

@if (session('success'))
    <div class="notification is-success">
        <button class="delete"></button>
        {{ session('success') }}
    </div>
@endif

@foreach ($cours as $cour)

{{$cour->numero_cours}}

{{$cour->designation}}

{{$cour->image}}

{{$cour->numero_cours}}

{{$cour->nombre_chapitres}}

{{$cour->prix}}

{{$cour->libelle}}

@endforeach

@endif

@endsection