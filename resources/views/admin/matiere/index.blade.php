@extends('layouts.app')

@section('content')
@if(Auth::user() && Auth::user()->role_id==1)

<div class="container">
    <div class="flex mt-4">
        <p class="control has-icons-right">
            <input class="input" type="search" placeholder="Rechercher..."/>
            <span class="icon is-small is-right"><i class="fas fa-search"></i></span>
        </p>
        <a href="{{ route('addMatiere') }}" class="has-icons-right" id="link-black">
            <span class="icon is-small is-right"><i class="fas fa-plus">Ajouter une matière  //matiere.index.blade</i></span>
        </a>
    </div>

    @if (session('danger'))
        <div class="notification is-danger has-text-centered my-4">
            <button class="delete"></button>
            {{ session('danger') }}
        </div>
    @endif
    @if (session('success'))
        <div class="notification is-success has-text-centered my-4">
            <button class="delete"></button>
            {{ session('success') }}
        </div>
    @endif
    @if($designation_categorie == null)
        <div class="notification is-warning has-text-centered my-4">
            <button class="delete"></button>
            Vous n'avez pas sélectionner de catégorie !
        </div>
    @endif 
    @if($matieres->isEmpty() && $designation_categorie != null)
    <div class="hauteur100"></div>
        <div class="notification is-warning has-text-centered my-4">
            <button class="delete"></button>
            Il n'y a pas de matière
        </div>
    @else

    <div class="hauteur100"></div>
    
    <h2 class="title is-4 has-text-centered mt-6 ">Liste de matière(s) :</h2>
    <h2 class="title is-5 has-text-centered mt-6" >De la catégorie <span class="has-text-weight-bold has-text-link">{{$designation_categorie}}</span></h2>  
    
    @foreach ($matieres as $matiere)
        <div class="card my-6 hauteur50" >
            <div class="card-content"  >
                <div class="media">
                <div class="media-content">
                    <div class="flex">
                        <p class="title is-4 position13" >{{$matiere->designation_matiere}}</p>
                    </div>
                </div>
            </div>

                <div class="content">
                    <div class="flex">
                        <div>
                        </div>
                        <div class="flex-bottom">
                                <!-- action=" route('categorie.edit', $categorie->id) " method="GET" -->      
                            <form action="{{ route('matiere.edit', $matiere->id) }}" method="GET">
                                @csrf
                                <button type="submit" class="button button-card is-info position57">Modifier</button>
                            </form>
                                <p>
                                    <a class = "button is-danger button-card modal-button position57" data-target = "#{{$matiere->id}}">Supprimer</a>
                                </p>
                                <div id="{{$matiere->id}}" class="modal" >
                                    <div class="modal-background"></div>
                                    <div class="modal-card">

                                        <header class="modal-card-head ">
                                            <div class="modal-card-title f">La matière {{$matiere->designation_matiere}} a t'elle une sous_matière ?</div>
                                            <button class="delete" id="{{$matiere->id}}" aria-label="close" ></button>                                        
                                        </header>

                                        <section class="modal-card-body">
                                            Souhaitez-vous supprimer la matière {{$matiere->designation_matiere}} ?
                                        </section>

                                        <form action="{{ route('matiere.destroy', $matiere->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                  
                                        <footer class="modal-card-foot" data-close>
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
                                
                                $('.delete').click(function (event) {
                                    $("#"+event.target.id).click(function() {
                                        $("html").removeClass("is-clipped");
                                        $(this).removeClass("is-active");
                                    });
                                });
                                </script>
                            <!-- 
                            <script>
                            $(".modal-button").click(function() {
                                var target = $(this).data("target");
                                $("html").addClass("is-clipped");
                                $(target).addClass("is-active");
                            });
                            
                            $('.delete').click(function (event) {
                                $("#"+event.target.id).click(function() {
                                    $("html").removeClass("is-clipped");
                                    $(this).removeClass("is-active");
                                });
                            });
                            </script>
                            -->
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    
    @endif
</div>
@else
<div class="notification is-danger has-text-centered my-4">
@if(Auth::user() && Auth::user()->role_id!=1)
Vous n'êtes pas autorisé !
@else
Votre session a expiré !
@endif
</div>
<button type="button" class="group bg-white rounded-md text-gray-500 inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                         @if(Auth::user() && Auth::user()->role_id==2)
                        <a href="/centre">
                        @elseif(Auth::user() && Auth::user()->role_id==3)
                        <a href="/stagiaire">
                        @elseif(Auth::user() && Auth::user()->role_id==4)
                        <a href="/formateur">
                        @elseif(Auth::user() && Auth::user()->role_id==5)
                        <a href="/organisme">
                        @else
                        <a href="/">
                        @endif
                        <i class="fas fa-home"></i>
                            <span>Acceuil</span>
                        </a>

</button>
@endif
<script>
    document.addEventListener('DOMContentLoaded', () => {
  (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
    const $notification = $delete.parentNode;

    $delete.addEventListener('click', () => {
      $notification.parentNode.removeChild($notification);
    });
  });
});
</script>
@endsection


<!-- 

<div class="container">
    <div class="flex mt-4">
        <p class="control has-icons-right">
            <input class="input" type="search" placeholder="Rechercher..."/>
            <span class="icon is-small is-right"><i class="fas fa-search"></i></span>
        </p>
        <a href="{{ route('addMatiere') }}" class="has-icons-right" id="link-black">
            Ajouter une matière Ajouter une matière
            <span class="icon is-small is-right"><i class="fas fa-plus"></i></span>
        </a>
    </div>





-->