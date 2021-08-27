@extends('layouts.app')

@section('content')
@if(Auth::user() && Auth::user()->role_id==4)

<div class="container">

<!--  'competence_id','designation_ca','designation_ma','designation_s_ma' -->
    
    
    <!--     -->
    

    @if (session('success'))
        <div class="notification is-success has-text-centered my-4 is-light">
        <button class="delete"></button>
            {{ session('success') }}
        </div>
    @endif
    <?php $a = "x"?>
    <?php $b = "x"?>
    
        
    
    <p class="title is-6"></p>
    @foreach ($competences as $competence)

    @if ($a != $competence->designation_ca && $a == "x")
    <?php $a = $competence->designation_ca ?>
    <p class="title is-4 "><u>{{$competence->designation_ca}}</u></p></h4>
    @endif

    @if ($a != $competence->designation_ca && $a != "x")
    <?php $a = $competence->designation_ca ?>
    <div class="hauteur60"></div>
    <p class="title is-4 "><u>{{$competence->designation_ca}}</u></p>
    @endif

    @if ($b != $competence->designation_ca." / ".$competence->designation_ma  )   
    <?php $b = $competence->designation_ca." / ".$competence->designation_ma ?>
    <div class="hauteur10"></div>
        
    @endif
    <div class="card my-2 hauteur50">
        <div class="card-content ">
            <div class="media">
                <div class="media-content">
                    <div class="flex">
                        <p class="title is-6">{{$competence->designation_ca}} - {{$competence->designation_ma}} / {{$competence->designation_s_ma}}</p>
                        <a class = "button is-danger button-card modal-button position" data-target = "#{{$competence->competence_id}}">Supprimer</a>
                        
                    </div>
                </div>
            </div>
            <div class="content ">
                <div class="flex">
                    <div>
                    </div>
                    <div class="flex-bottom " >
                           
                            <div id="{{$competence->competence_id}}" class="modal">
                                <div class="modal-background"></div>
                                <div class="modal-card">
                                    <header class="modal-card-head">
                                    <p class="modal-card-title"></p>
                                    <button class="delete" id="{{$competence->competence_id}}" aria-label="close"></button>
                                    </header>
                                    <section class="modal-card-body">
                                        Souhaitez-vous supprimer la compétence :  {{$competence->designation_s_ma}} ?
                                    </section>
                                    <form action="{{ route('competence.destroy', $competence->competence_id) }}" method="POST">
                        <!--                -->
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
<script>
    document.addEventListener('DOMContentLoaded', () => {
            (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {const $notification = $delete.parentNode;
              $delete.addEventListener('click', () => {$notification.parentNode.removeChild($notification);
              });
            });
        });


</script>   
    
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
                            <span>Acceuil Acceuil</span>
                        </a>

</button>
@endif  


@endsection