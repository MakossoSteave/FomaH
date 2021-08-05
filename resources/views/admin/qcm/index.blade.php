@extends('layouts.app')

@section('content')

<div class="container">
    <div class="flex mt-4">
        <p class="control has-icons-right">
            <input class="input" type="search" placeholder="Rechercher..."/>
            <span class="icon is-small is-right"><i class="fas fa-search"></i></span>
        </p>
        <a href="{{ url('addQcm', request()->route('id'))}}" class="has-icons-right" id="link-black">
            Ajouter un QCM
            <span class="icon is-small is-right"><i class="fas fa-plus"></i></span>
        </a>
    </div>
    
    @if (session('success'))
        <div class="notification is-success has-text-centered my-4">
            {{ session('success') }}
        </div>
    @endif

    @if($qcms->isEmpty())
        <div class="notification is-warning has-text-centered my-4">
            Aucun QCM n'existe pour ce cours
        </div>
    @else

    @foreach($qcms as $qcm)
    <div class="card my-6">
        <div class="card-content">
            <div class="media">
            <div class="media-content">
                <p class="title is-4">{{$qcm->designation}}</p>
                @foreach($qcm->question_qcm as $questions)
                <p class="subtitle is-5 mt-4"> {{$questions->question}}</p>
                <p class="subtitle is-5"> {{$questions->explication}}</p>
                @foreach($questions->reponse_question_qcm as $reponses)
                    <p class="subtitle is-6 {{ ($reponses->validation == 1) ?  'has-text-success' : 'has-text-danger'}}"> {{$reponses->reponse}}</p>
                    @endforeach
                @endforeach
            </div>
        </div>

            <div class="content">
                <div class="flex">
                    <div>
                    </div>
                    <div class="flex-bottom">
                        <form action="{{ route('qcm.edit', $qcm->id) }}" method="GET">
                            @csrf
                            <button type="submit" class="button button-card is-info">Modifier</button>
                        </form>
                            <p>
                                <a class = "button is-danger button-card modal-button" data-target = "#{{$qcm->id}}">Supprimer</a>
                            </p>
                            <div id="{{$qcm->id}}" class="modal">
                                <div class="modal-background"></div>
                                <div class="modal-card">
                                    <header class="modal-card-head">
                                    <p class="modal-card-title">Confirmez-vous la suppression de {{$qcm->designation}}</p>
                                    <button class="delete" aria-label="close"></button>
                                    </header>
                                    <section class="modal-card-body">
                                        Souhaitez-vous supprimer le cours {{$qcm->designation}} ?
                                    </section>
                                    <form action="{{ route('qcm.destroy', $qcm->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <footer class="modal-card-foot">
                                    <button class="button is-success">Confirmer</button>
                                    </footer>
                                    </form>
                                </div>
                            </div>
                            <script>
                            $(".modal-button").click(function() {
                                var target = $(this).data("target");
                                $("html").addClass("is-clipped");
                                $(target).addClass("is-active");
                            });
                            
                            $(".delete").click(function() {
                                var target = $(".modal-button").data("target");
                                $("html").removeClass("is-clipped");
                                $(target).removeClass("is-active");
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endforeach
    @endif
</div>

@endsection
