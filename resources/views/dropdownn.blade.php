<!DOCTYPE html>
<html lang="en">
<head>
  <title>Laravel 8 Dynamic Dependent Dropdown using Jquery Ajax - XpertPhp</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
 
<div class="container">
  <h2>Laravel 8 Dynamic Dependent Dropdown using Jquery Ajax</h2>
    <div class="form-group">
      <label for="categoriee">Categorie :</label>
    <!-- c'est le id="categorie" qui récupère l'information-->
    <select id="categorie" name="categorie" class="form-control">
        <option value="" selected disabled>Selectionner une Categorie</option>
         @foreach($categories as $key => $categorie)
         <option value="{{$key}}"> {{$categorie}}</option>
         @endforeach
         </select>
    </div>

    <div class="form-group">
      <label for="matieree">Matiere :</label>
      <!-- c'est le id="matiere" qui récupère l'information-->
      <select id="matiere" name="matiere"  class="form-control"></select>
    </div>
    
    <div class="form-group">
        <label for="sousmatieree">Sous Matiere :</label>
        <select id="sousmatiere" name="sousmatiere"  class="form-control"></select>
    </div>
</div>


<script type=text/javascript>
  $('#categorie').change(function(){
  var categorieID = $(this).val();  
  if(categorieID){
    $.ajax({
      type:"GET",
      url:"{{url('getMatiere')}}?categorie_id="+categorieID,
      success:function(res){        
      if(res){
        $("#matiere").empty();
        $("#matiere").append('<option>Selectionner une matiere</option>');
        $.each(res,function(key,value){
          $("#matiere").append('<option value="'+key+'">'+value+'</option>');
        });
      
      }else{
        $("#matiere").empty();
      }
      }
    });
  }else{
    $("#matiere").empty();
    $("#city").empty();
  }   
  });
  /* <!--
  $('#state').on('change',function(){
  var stateID = $(this).val();  
  if(stateID){
    $.ajax({
      type:"GET",
      url:"{{url('getCity')}}?state_id="+stateID,
      success:function(res){        
      if(res){
        $("#city").empty();
 $("#city").append('<option>Select City</option>');
        $.each(res,function(key,value){
          $("#city").append('<option value="'+key+'">'+value+'</option>');
        });
      
      }else{
        $("#city").empty();
      }
      }
    });
  }else{
    $("#city").empty();
  }
    
  });
--> */
</script>

</body>
</html>