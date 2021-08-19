@extends('layouts.app')

@section('content')
@if(Auth::user())



<!-- This example requires Tailwind CSS v2.0+ -->
<div class="bg-white  overflow-hidden sm:rounded-lg"><!-- shadow -->
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 text-center">
        Paramètres
        </h3>
       
        <div class="has-text-centered mt-5 containerProfil" >
        <figure class="image is-96x96 is-inline-block" >
      
            <img class="is-rounded" style="position:relative;"   src="{{ URL::asset('/') }}img/user/@if($id->image==null)profile-picture.png @else{{$id->image}}  @endif"/>
           <a type="button" class="modal-button"  data-target = "#Modif_profil_image"> <i  class="fas fa-pencil-alt" style="position:absolute;"></i></a>
        <div class="mt-3">
           @if($User && $User->prenom!=null)
           {{ $User->prenom}}
           @endif 
           @if($User && $User->nom!=null)
           {{$User->nom}}
           @endif 
        </div>
           <div id="Modif_profil_image" class="modal">
                                <div class="modal-background"></div>
                                <div class="modal-card">
                                    <header class="modal-card-head">
                                    <p class="modal-card-title">Modifier l'image de profil </p>
                                    <button class="delete" aria-label="close"></button>
                                    </header>
                                    <form method="POST" action="{{route('parametre.update', $id->id)}}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <section class="modal-card-body">
                                    <div id="file-js-image-chapitre" class="file has-name">
                    <label class="file-label">
                        <input class="file-input" type="file" name="image">
                        <span class="file-cta">
                        <span class="file-icon">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="file-label">
                            Choisir une image
                        </span>
                        </span>
                        <span class="file-name">
                            Aucune image
                        </span>
                    </label>
            </div>

                <script>
                const fileInput = document.querySelector('#file-js-image-chapitre input[type=file]');
                fileInput.onchange = () => {
                    if (fileInput.files.length > 0) {
                    const fileName = document.querySelector('#file-js-image-chapitre .file-name');
                    fileName.textContent = fileInput.files[0].name;
                    }
                }
                </script>
                                    </section>
                                    
                                   
                                    <footer class="modal-card-foot">
                                    <button class="button is-success">Modifier</button>
                                    </footer>
                                    </form>
                                </div>
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
        </figure>
        
      
    </div>

   



    <div class="sm:w-3/1 px-20">
    @if (session('success'))
        <div class="notification is-success has-text-centered my-4">
            <button class="delete"></button>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="notification is-danger has-text-centered my-4">
            <button class="delete"></button>
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
    <div class="notification is-danger">
        <button class="delete"></button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
    </div>
    @endif
    <div class="mt-4">
            <dl>
               @if (Auth::user()->role_id==1)
               <form method="POST" action="{{route('parametre.update', $id->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
               <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Nom
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{$id->name}}
                        <input type="text" class="focus:outline-blue focus:ring focus:border-blue-300 p-2"
                            placeholder="Nom" name="nom" >
                        <input type="submit"  class="font-medium text-indigo-600 hover:text-indigo-500 parametreButton"
                            value="modifier"
                        />
                    </dd>
                </div>
               </form>
                @endif
                @if($User && $User->prenom==null || $User && Auth::user()->role_id==1)
                <form method="POST" action="{{route('parametre.update', $id->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
            
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Prénom
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    @if($User && $User->prenom!=null)
                    {{$User->prenom}}
                    @endif
                    
                    <input type="text" class="focus:outline-blue focus:ring focus:border-blue-300 p-2"
                        
                        placeholder="Prénom" name="prenom">
                    

                    <input type="submit"  class="font-medium text-indigo-600 hover:text-indigo-500 parametreButton"
                            value="modifier"/>
                    
                    </dd>
                </div>
            
                </form>
                @endif
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Status
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{$role}}
                    </dd>
                </div>
                <!--            xxx   email   xxx                                -->

                <form method="POST" action="{{route('parametre.update', $id->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                        
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Email

                                </dt>
                            
                            
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <spam>
                                    {{$id->email}}
                                
                                    <input type="text" class="focus:outline-blue focus:ring focus:border-blue-300 p-2"
                                        placeholder="Email" name="email" >
                                    </spam>
                                    
                                        <spam >
                                        <input type="submit"  class="font-medium text-indigo-600 hover:text-indigo-500 parametreButton" value="modifier" >
                                        </spam>
                                    
                                </dd>
                            
                        </div>
                            
                </form>

                <!--            xxx      xxx           -->



                @if($User)
                <form method="POST"  action="{{route('parametre.update', $id->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                    Téléphone

                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    @if($User && $User->telephone!=null)   
                    {{$User->telephone}}
                    @endif
                        <input type="text" class="focus:outline-blue focus:ring focus:border-blue-300 p-2"
                    
                        placeholder="Numéro de téléphone" name="telephone">

                        <input type="submit"  class="font-medium text-indigo-600 hover:text-indigo-500 parametreButton"
                            value="modifier"
                        />

                    </dd>
                </div>
                </form>
                @endif
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Date de création du compte
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{$id->created_at}}
                    </dd>
                </div>
               
        
                

            <!--          XXXXX     XXXXX     XXXXX     XXXXX     XXXXX          -->
            

            <form action="{{ route('cv.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
                    @csrf
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">   
                
                        <input type="hidden" name="id_chapitree" value="{{request()->route('id')}}">
                        <input type="hidden" name="id_user" value="{{Auth::user()->id}}">
                    <!--    {{Auth::user()->id}}    -->

                        <div class="field">
                            <dt class="text-sm font-medium text-gray-500">
                                Ajouter son cv
                            </dt>
                            
                                    <div class="control">
                                        <input name="designationcv" class="input" type="hidden" value="cvformateur">
                                    </div>
                        </div>          

                        <div class="field">
                            
                                <div id="file-cv" class="">
                                        <label class="file-label">
                                            <input class="file-input" type="file" name="lien">
                                                <span class="file-cta">
                                                    <span class="file-icon">
                                                        <i class="fas fa-upload"></i>
                                                    </span>
                                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                        Charger votre cv
                                                    </dd>
                                                </span>
                            
                                        </label>
                                </div>

                                
                        </div>

                            <input type="submit"  class="font-medium text-indigo-600 hover:text-indigo-500 parametreButton " value="créer ou modifier"/>  
                    
                    
                </div>    
            </form>

            <!--          XXXXX     XXXXX     XXXXX     XXXXX     XXXXX          -->

            

                <form method="POST" action="{{route('parametre.update', $id->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Mot de passe actuel
                    </dt>
                    <input class="focus:outline-blue focus:ring focus:border-blue-300" type="password"
                        placeholder="Mot de passe actuel" name="motdepasse">
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Nouveau mot de passe
                    </dt>
                    <input class="focus:outline-blue focus:ring focus:border-blue-300" type="password"
                        placeholder="Nouveau mot de passe" name="Nouveau_motdepasse"/>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                    Confirmation du nouveau mot de passe
                    </dt>
                    <input class="focus:outline-blue focus:ring focus:border-blue-300" type="password"
                        placeholder="Confirmation du nouveau mot de passe" name="Nouveau_motdepasse_confirmation"/>
                        <input type="submit"  class="font-medium text-indigo-600 hover:text-indigo-500 parametreButton"
                            value="modifier"
                        />
                </div>
                </form>
                
                
            </dl>
        </div>
    </div>
    </div>
<br>
<footer class="text-gray-100 bg-gray-800">
    <div class="max-w-3xl mx-auto py-6">
        <h1 class="text-center text-lg lg:text-2xl">
            Nous rejoindre <br>
            c'est avoir les conseils d'un professionnel
        </h1>
        <div class="flex justify-center mt-6">
            <div class=" bg-white rounded-md">
                <div class="flex flex-wrap justify-between md:flex-row">
                    <input type="email"
                        class="m-1 p-2 appearance-none text-gray-700 text-sm focus:placeholder-transparent"
                        placeholder="Entrez votre email" aria-label="Entrez votre email">
                    <button
                        class="w-full m-1 p-2 text-sm bg-gray-800 rounded font-semibold uppercase lg:w-auto hover:bg-gray-700">
                        s'abonner
                    </button>
                </div>
            </div>
        </div>
        <hr class="h-px mt-6 bg-gray-700 border-none">
        <div class="flex flex-col items-center justify-between mt-6 md:flex-row">
            <div>
                <a href="#" class="text-xl font-bold text-gray-100 hover:text-gray-400">Perfect Ingénieurie</a>
            </div>
            <div class="flex mt-4 md:m-0">
                <a href="" class="px-4 text-sm text-gray-100 font medium hover:text-gray-400">A propos de nous </a>
                <a href="" class="px-4 text-sm text-gray-100 font medium hover:text-gray-400">Contactez nous </a>
                <a href="" class="px-4 text-sm text-gray-100 font medium hover:text-gray-400">Blog</a>
            </div>
        </div>
    </div>
</footer>



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