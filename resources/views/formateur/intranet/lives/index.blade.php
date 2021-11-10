@extends('layouts.appIntranetFormateur')

@section('content')
@if(Auth::user())
<div class="column is-9">
    <div class="content is-medium">
        <h3 class="has-text-centered">Vos lives</h2>
            <span class="percentage mb-4"></span>
    </div>
    <div class="flex mt-2">
        <div>

        </div>


        <p>
            <a class="button-card modal-button has-icons-right" id="link-black" data-target="#1">
                Créer un live
                <span class="icon is-small is-right"><i class="fas fa-plus"></i></span>
            </a>
        </p>
        <div id="1" class="modal">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Créer un live</p>
                    <button class="delete" aria-label="close"></button>
                </header>
                <form action="{{route('create_live_formateur')}}" method="POST">
                    @csrf
                    <section class="modal-card-body">
                        <div class="field">
                            <label class="label">Date</label>
                            <div class="control">
                                <input name="date_meeting" class="input" type="datetime-local">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Lien</label>
                            <div class="control">
                                <input name="lien" class="input" type="text">
                            </div>
                        </div>
                    </section>
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
    <div class="columns is-multiline">
        @foreach($lives as $live)
        <div class="column is-4">
            <article>
                <div class="card mt-2">
                    <header class="card-header">
                        <p class="card-header-title">
                            <?php $date = new DateTime($live['date_meeting']) ?>
                            Live du {{date_format($date, 'd/m/Y à H:i')}}h
                        </p>
                    </header>
                    <div class="card-content">
                        <div class="text-link-live content">
                            <a href="{{$live['lien']}}">
                                <h1 class="has-text-centered mb-4 is-size-3">{{$live['lien']}}</h1>
                            </a>
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