@extends('layouts.appIntranetFormateur')

@section('content')
@if(Auth::user())
            <div class="column is-9">
            <div class="content is-medium">
            <h3 class="has-text-centered">Vos sessions</h2>
                <span class="percentage mb-4"></span>
            </div>
                    <div class="columns is-multiline">
                    @foreach($formateurFormations as $formateurFormation)
                        <div class="column is-4">
                            <article>
                                <div class="card">
                                    <header class="card-header">
                                        <p class="card-header-title">
                                        {{$formateurFormation['nom']}} {{$formateurFormation['prenom']}}
                                        </p>
                                    </header>
                                    <div class="card-content">
                                        <div class="content">
                                        <h1 class="has-text-centered mb-4 is-size-3">{{$formateurFormation['libelle']}}</h1>
                                        <span class="percentage mb-4">{{$formateurFormation['progression']}}% de progression</span>
                                        <progress class="progress is-success" value="{{$formateurFormation['progression']}}" max="100"></progress>
                                        <?php $date = new DateTime($formateurFormation['date_debut']) ?>
                                        <h3>Session du : {{date_format($date, 'd-m-Y')}}</h3>
                                        <?php $date = new DateTime($formateurFormation['date_fin']) ?>
                                        <h3 class="mb-2">Au : {{date_format($date, 'd-m-Y')}}</h3>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                    </div>
    </section>

@else
<div class="notification is-danger has-text-centered my-4">
Votre session a expiré !
</div>
<button type="button" class="group bg-white rounded-md text-gray-500 inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <a href="/">
                        <i class="fas fa-home"></i>
                            <span>Acceuil</span>
                        </a>

</button>
@endif
@endsection