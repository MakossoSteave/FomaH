@extends('layouts.app')

@section('content')

<div class="container">
    <div class="flex mt-4">
        
    </div>
    
    

    

    @foreach ($categories as $categorie)
    <div class="card my-6">
        <div class="card-content">
            <div class="media">
            <div class="media-content">
                <div class="flex">
                    <p class="title is-4">{{$categorie->designation}}</p>
                </div>
            </div>
        </div>

            <div class="content">
                <div class="flex">
                    <div>
                    </div>
                    <div class="flex-bottom">
                        
                        <form action="{{ route('categorie.edit', $categorie->id) }}" method="GET">
                            @csrf
                            <button type="submit" class="button button-card is-info">Modifier</button>
                        </form>
                        
                            <p>
                                <a class = "button is-danger button-card modal-button" data-target = "#{{$categorie->id}}">Supprimer</a>
                            </p>
                            <div id="{{$categorie->id}}" class="modal">
                                <div class="modal-background"></div>
                                <div class="modal-card">
                                    <header class="modal-card-head">
                                    <p class="modal-card-title">Confirmez-vous la suppression de {{$categorie->designation}}</p>
                                    <button class="delete" aria-label="close"></button>
                                    </header>
                                    <section class="modal-card-body">
                                        Souhaitez-vous supprimer la catégorie {{$categorie->designation}} ?
                                    </section>
                                    <form action="{{ route('categorie.destroy', $categorie->id) }}" method="POST">
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