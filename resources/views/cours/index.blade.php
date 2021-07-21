@extends('layouts.app')

@section('content')

@if($cours->isEmpty())

<p>Aucun cours n'existe pour cette formation</p>

@else
<?PHP highlight_string("<?php\n\$data =\n" . var_export($cours, true) . ";\n?>");
?>
@foreach ($cours as $cour)

{{$cour->numero_cours}}

{{$cour->designation}}

{{$cour->image}}

{{$cour->numero_cours}}

{{$cour->nombre_chapitres}}

{{$cour->prix}}

{{$cour->formation_id}}</br>
formation:</br>
libelle = {{$cour->libelle}}</br>
volume_horaire = {{$cour->volume_horaire}}
@endforeach



@endif

@endsection