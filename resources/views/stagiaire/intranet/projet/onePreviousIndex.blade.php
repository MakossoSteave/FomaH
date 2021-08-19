@extends('layouts.appIntranetNeutral')

@section('content')

@if(Auth::user())

<div class="column is-9">
    <div class="content is-medium">
    <h1 class="has-text-centered">Projet</h1>
        <div class="box mt-4">
                <article class="message is-primary">
                    <span class="icon has-text-primary">
                    </span>
                    <div class="message-body">
                    {{$projet->description}}
                    </div>
                </article>
                @if(!empty($projet->document))
                @foreach($projet->document as $document)
                    <embed class="docSize mt-4" src="{{ URL::asset('/') }}doc/projet/{{$document->lien}}" alt="Placeholder image">
                @endforeach
                @endif
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