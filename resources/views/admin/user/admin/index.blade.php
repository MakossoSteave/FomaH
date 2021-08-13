@extends('layouts.app')

@section('content')
@if(Auth::user() && Auth::user()->role_id==1)

<div class="container">
<div class="flex mt-4">
        <p class="control has-icons-right">
            <input class="input" type="search" placeholder="Rechercher..."/>
            <span class="icon is-small is-right"><i class="fas fa-search"></i></span>
        </p>
        <a href="{{ route('admin.create') }}" class="has-icons-right" id="link-black">
            Ajouter un administrateur
            <span class="icon is-small is-right"><i class="fas fa-plus"></i></span>
        </a>
    </div>
    @if (session('success'))
        <div class="notification is-success has-text-centered my-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="notification is-danger has-text-centered my-4">
        <button class="delete"></button>
            {{ session('error') }}
        </div>
    @endif

    @if($users->isEmpty())
        <div class="notification is-warning has-text-centered my-4">
            Aucun autre administrateur n'existe
        </div>
    @else

  

    @foreach ($users as $user)
    <div class="card my-6">
        <div class="card-content">
            <div class="media">
            @if(! empty($user->image))
            <div class="media-left">
            <figure class="image is-96x96 containerProfil">
                <img class="image is-rounded" src="{{ URL::asset('/') }}img/user/{{$user->image}}" alt="Placeholder image">
            </figure>
            </div>
            @endif
            
            <div class="media-content">
                <div class="flex">
            <div>
              
            </div>
                
                </div>
            </div>
        </div>

            <div class="content">
                <div class="flex">
                    <div>
                        <p><span class="title is-6"> Nom: </span> <span class="subtitle is-6"> {{$user->name}}</span></p>
                        <p><span class="title is-6">Email:</span> <span class="subtitle is-6">{{$user->email}}</span></p>
                        <p><span class="title is-6">Role:</span> <span class="subtitle is-6">{{$user->type}}</span></p>
                      

                    </div>
                    <div class="flex-bottom">
                        <form action="{{ route('admin.edit', $user->id) }}" method="GET">
                            @csrf
                            <button type="submit" class="button button-card is-info">Modifier</button>
                        </form>
                            <p>
                                <a class = "button is-danger button-card modal-button" data-target = "#{{$user->id}}">Supprimer</a>
                            </p>
                            <div id="{{$user->id}}" class="modal">
                                <div class="modal-background"></div>
                                <div class="modal-card">
                                    <header class="modal-card-head">
                                    <p class="modal-card-title">Suppression du l'administrateur {{$user->name}}</p>
                                    <button class="delete" aria-label="close"></button>
                                    </header>
                                    <section class="modal-card-body">
                                        Souhaitez-vous supprimer l'administrateur {{$user->name}} ?
                                    </section>
                                    <form action="{{ route('admin.destroy', $user->id) }}" method="POST">
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
    {!! $users->links() !!}
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
                        <a href="/user">
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
@endsection