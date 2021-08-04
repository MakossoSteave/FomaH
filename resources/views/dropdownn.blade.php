@extends('layouts.app')

@section('content')


<div class="container">
  <div class="notification is-primary">
    <h3 class="title is-3">Déclaration de compétence</h3>
      <!-- <div class="hauteur"> -->
      <form action="{{ route('competence.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf
        <span>  {{Auth::user()->id}} </span>
        <input type="hidden" id="userId" name="userId" value="{{Auth::user()->id}}">

      <!-- X X X X X Catégorie -->
      <div class="form-group hauteur_dropdown">
        <div>
          <h5 class="title is-5">Catégorie :</h5>
        </div>
        <!-- c'est le id="categorie" qui récupère l'information-->
            <div class="control has-icons-left">
              <div class="select">
                <div class="select is-info">

                  <select id="categorie" name="categorie" class="form-control taille">
                    <option selected>Sélectionner une catégorie</option>
                    @foreach($categories as $key => $categorie)
                    <option value="{{$key}}"> {{$categorie}}</option>
                    @endforeach
                  </select>

                </div>
              </div>
              <div class="icon is-small is-left">
                <i class="fa fa-certificate " aria-hidden="true" style=color:#0080FF></i>
              </div>
            </div>
      </div>
      <!-- XX XX XX XX XX Matière -->
      <div class="form-group hauteur_dropdown">
        <div>
          <h5 class="title is-5">Matière :</h5>
        </div>
        <!-- c'est le id="matiere" qui récupère l'information-->
        <div class="control has-icons-left">
          <div class="select is-link">
            <select id="matiere" name="matiere" class="form-control taille"></select>
          </div>
          <div class="icon is-small is-left">
            <i class="fa fa-certificate " aria-hidden="true" style=color:#0080FF></i>
          </div>
        </div>
      </div>
        <!-- XXX XXX XXX XXX XXX Sous_Matière -->
        <div class="form-group hauteur_dropdown">
          <div>
            <h5 class="title is-5">Sous Matière :</h5>
          </div>
          <div class="control has-icons-left">
            <div class="select is-link">
              <select id="sousmatiere" name="sousmatiere" class="form-control taille"></select>
            </div>
            <div class="icon is-small is-left">
              <i class="fa fa-certificate " aria-hidden="true" style=color:#0080FF></i>
            </div>
          </div>
        </div>
              <div class="control mt-4 mb-4">
                <button type="submit" class="button is-fullwidth is-link is-rounded">Créer</button>
            </div>
      </form>
    </div>
</div>
      <script type=text/javascript>
        $('#categorie').change(function() {
          var categorieID = $(this).val();
          if (categorieID) {
            $.ajax({
              type: "GET",
              url: "{{url('getMatiere')}}?categorie_id=" + categorieID,
              success: function(res) {
                if (res) {
                  $("#matiere").empty();
                  $("#matiere").append('<option>Selectionner une matiere</option>');
                  $.each(res, function(key, value) {
                    $("#matiere").append('<option value="' + key + '">' + value + '</option>');
                  });

                } else {
                  $("#matiere").empty();
                }
              }
            });
          } else {
            $("#matiere").empty();
            $("#sousmatiere").empty();
          }
        });

        $('#matiere').on('change', function() {
          var matiereID = $(this).val();
          if (matiereID) {
            $.ajax({
              type: "GET",
              url: "{{url('getSousMatiere')}}?matiere_id=" + matiereID,
              success: function(res) {
                if (res) {
                  $("#sousmatiere").empty();
                  $("#sousmatiere").append('<option>Selectionner une sous matiere</option>');
                  $.each(res, function(key, value) {
                    $("#sousmatiere").append('<option value="' + key + '">' + value + '</option>');
                  });

                } else {
                  $("#sousmatiere").empty();
                }
              }
            });
          } else {
            $("#sousmatiere").empty();
          }

        });
      </script>

  </body>

  </html>
  @endsection