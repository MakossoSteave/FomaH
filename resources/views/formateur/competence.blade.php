@extends('layouts.app')

@section('content')

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
    <div class="hauteur50"></div>
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
                                    <button class="delete" aria-label="close"></button>
                                    </header>
                                    <section class="modal-card-body">
                                        Souhaitez-vous supprimer la catégorie {{$competence->designation_ca}} ?
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
<script>
    document.addEventListener('DOMContentLoaded', () => {
            (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {const $notification = $delete.parentNode;
              $delete.addEventListener('click', () => {$notification.parentNode.removeChild($notification);
              });
            });
        });


</script>   
    
</div>

@endsection