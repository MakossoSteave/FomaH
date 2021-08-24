@extends('layouts.appIntranetNeutral')

@section('content')

@if(Auth::user())

<div class="column is-9">
@if (session('warning'))
        <div class="column is-9 notification is-warning has-text-centered ">
        <button class="delete"></button>
            {{ session('warning') }}
        </div>
 @endif
    <div class="content is-medium">
        <h3 class="title is-3">{{$chapitre->numero_chapitre}}. {{$chapitre->designation}}</h3>
        <video class="video" width="100%" controls>
            <source src="{{ URL::asset('/') }}video/chapitre/{{$chapitre->video}}" >
            Votre lecteur ne supporte pas ce type de video
        </video>
            @foreach($chapitre->section->reverse() as $section)
                <div class="box mt-4">
                    <h4 id="const" class="title is-3 has-text-centered">{{$section->designation}}</h4>
                        <article class="message is-primary">
                            <span class="icon has-text-primary">
                            </span>
                            <div class="message-body">
                            {{$section->contenu}}
                            </div>
                        </article>
                        @if(! empty($section->image))
                            <img class="imageSection" src="{{ URL::asset('/') }}img/section/{{$section->image}}" alt="Placeholder image">
                        @endif
                </div>
            @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
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