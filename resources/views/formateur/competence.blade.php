@extends('layouts.app')

<h1>page des competences</h1>

@section('content')
    <div class="mt-5">
                        <label class="block">
                            <div class="flex justify-between items-center">
                                <div class="text-sm font-bold text-gray-700 tracking-wide">
                                    Dans quel domaine je déclare une competence
                                </div>

                            </div>
                            <select class="form-select block w-full mt-1  @error('role') is-invalid @enderror"
                                name="role">
                                @foreach($Matieres as $matiere)
                                <option value="{{$matiere->id}}">{{$matiere->designation_matiere}}</option>
                                @endforeach
                                <!--
                                @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                -->
                            </select>
                        </label>
    </div>
    <div class="mt-5">
                        <label class="block">
                            <div class="flex justify-between items-center">
                                <div class="text-sm font-bold text-gray-700 tracking-wide">
                                    Dans quel domaine je déclare une competence
                                </div>

                            </div>
                            <select class="form-select block w-full mt-1  @error('role') is-invalid @enderror"
                                name="role">
                                @foreach($Sous_matieres as $sous_matiere)
                                <option value="{{$sous_matiere->id}}">{{$sous_matiere->designation_sous_matiere}}</option>
                                @endforeach
                                <!--
                                @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                -->
                            </select>
                        </label>
    </div>

    

@endsection