@extends('layouts.app')

@section('content')
<section class="py-5">
    <div class="container px-2 mx-auto">
        <div class="flex flex-wrap -mx-1">
            <div class="w-full md:w-2/5 px-3 order-1 md:order-0">
                <div class="max-w-md">
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('centre.index') }}" title="Go back"> <i
                                class="fas fa-backward "></i> </a>
                    </div>
                    <h2 class=" text-3xl md:text-4xl font-bold font-heading" style="text-align:center">Modifier</h2>

                    <div class="form-signup-dig">
                        <div class="w-full max-w-xs">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <form class="max-w-md mb-2 form-input" action="{{ route('centre.update', $data->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <label class="block text-grey-darker text-sm font-bold mb-2" for="username">
                                        Intitulé de formation
                                    </label>
                                    <input
                                        class="shadow appearance-none border rounded w-full h-12 py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline"
                                        id="text" type="text" name="libelle" value="{{ $data->libelle }}"
                                        placeholder="{{$data->libelle }}">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-grey-darker text-sm font-bold mb-2" for="username">
                                        Description
                                    </label>
                                    <input
                                        class="shadow appearance-none border rounded w-full h-12 py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline"
                                        id="text" type="text" name="description" value="{{$data->description}}"
                                        placeholder="{{$data->description}}">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                                        Code de reférence
                                    </label>
                                    <input
                                        class="shadow appearance-none border border rounded h-12 w-full py-2 px-3 text-grey-darker mb-3 leading-tight focus:outline-none focus:shadow-outline"
                                        id="text" name="reference" type="text" Value="{{$data->reference}}"
                                        placeholder="{{$data->reference}}">
                                </div>
                                <div class="mb-6">
                                    <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                                        Prix
                                    </label>
                                    <input
                                        class="shadow appearance-none border border rounded w-full h-12 py-2 px-3 text-grey-darker mb-3 leading-tight focus:outline-none focus:shadow-outline"
                                        name="prix" type="number" name="prix" value="{{ $data->prix}}"
                                        placeholder=" {{$data->prix}}">
                                    <input
                                        class="shadow appearance-none border border rounded w-full h-12 py-2 px-3 text-grey-darker mb-3 leading-tight focus:outline-none focus:shadow-outline"
                                        id="ref_user" name="userRef" type="hidden" value="{{Auth::user()->id}}">

                                </div>
                                <div class="mb-4">
                                    <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                                        Nombre d'heure
                                    </label>
                                    <input
                                        class="shadow appearance-none border border rounded w-full h-12 py-2 px-3 text-grey-darker mb-3 leading-tight focus:outline-none focus:shadow-outline"
                                        id="password" name="volume_horaire" type="number" placeholder="Nombre d'heure" value="{{$data->volume_horaire}}">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                                        Etat
                                    </label>
                                    <select class="form-select block w-full mt-1"  name="categorie_id">
                                          
                                            <option value="{{$data->etat}}">{{$data->etat}} </option>
                                            <option value="{{!$data->etat}}">{{!$data->etat}} </option>
                                        </select>
                                </div>
                                <div class="mb-6">
                                    <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                                        Categorie
                                    </label>
                                        <select class="form-select block w-full mt-1"  name="categorie_id">
                                            @foreach($Categorie as $categorie)
                                            <option value="{{$categorie->id}}" @if($data->categorie_id == $categorie->id) selected @endif>{{$categorie->designation}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="flex items-center justify-between">
                                    <button type="submit" class="bg-indigo-500 text-gray-100 p-4 w-full rounded-full tracking-wide
                                font-semibold font-display focus:outline-none focus:shadow-outline hover:bg-indigo-600
                                shadow-lg">
                                        Sauvegarder
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/2 px-3 order-0 md:order-1 mb-12 md:mb-0"><img
                    class="sm:max-w-sm lg:max-w-full mx-auto"
                    src="https://www.perfect-ingenierie.com/wp-content/uploads/2020/11/cropped-IMG_20200727_153543.png"
                    alt=""></div>
        </div>
    </div>
</section>
@endsection