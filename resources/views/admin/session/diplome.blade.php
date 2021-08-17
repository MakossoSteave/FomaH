<!DOCTYPE html>

<html>

<head>

    <title>titre</title>
  <style>
      @page { size: 620px 775px landscape; }
  </style>
</head>

<body><div style="width:650px; height:450px; padding:20px; text-align:center; border: 10px solid #667EEA">
<div style="width:600px; height:400px; padding:20px; text-align:center; border: 5px solid #667EEA">

                    <div  class="text-2xl tracking-wide ml-2 font-semibold">
                        <img  src="<?php echo $_SERVER["DOCUMENT_ROOT"].'/favicon.png';?>" width="25" height="25">
                        HubDigitForma</div>       
<span style="font-size:50px; font-weight:bold">Certificat d'achèvement</span>
       <br><br>
       <span style="font-size:25px"><i>Ceci certifie que</i></span>
       <br><br>
       <span style="font-size:30px"><b>{{$prenom}} {{$nom}}</b></span><br/><br/>
       <span style="font-size:25px"><i>a terminé le {{$type}}</i></span> <br/><br/>
       <span style="font-size:30px">{{$titre}}</span> <br/><br/>
      <!-- <span style="font-size:20px">with score of <b>$grade.getPoints()%</b></span> <br/><br/><br/><br/>-->
       <span style="font-size:25px"><i>Date d'obtention: {{$date}}</i></span><br>
     
      
</div>
</div>
</body>

</html>