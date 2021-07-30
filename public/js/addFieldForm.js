var counter = 0;

function addQuestion(){

    var addQuestion = $("#addQuestion");

    addQuestion.append("<div class='field' id='questionReponse"+counter+"'></div>");

    var divQuestion = $("#questionReponse"+counter);

    var buttonDeleteQuestion = "<div class='flex'><div></div><div class='mt-2 mb-2'><a id='"+counter+"' class='has-icons-right has-text-danger deleteQuestion'>Supprimer la question<span class='icon is-small is-right'><i class='fas fa-trash-alt'></i></span></a></div></div>";

    divQuestion.append(buttonDeleteQuestion);

        var questionItem = "<div class='field' id='questions'><label class='label'>Question</label><div class='control'><input name='qcm["+counter+"][question]' class='input' type='text' placeholder='Question'></div></div><div class='field' id='explications'><label class='label'>Explication</label><div class='control'><textarea name='explication[]' class='textarea' type='text' placeholder='Explication'></textarea></div></div>";

    divQuestion.append(questionItem);

    for (var index = 0; index < 4; index++) {
        var reponseItem = "<div class='field reponse'><label class='label'>Réponse</label><div class='control'><input name='qcm["+counter+"][reponse"+index+"]' class='input' type='text' placeholder='Réponse'></div></div><div class='field'><label class='label'>Choisir la validation de la réponse</label><div class='control'><div class='select'><select name='qcm["+counter+"][validation"+index+"]'><option value='1'>Bonne réponse</option><option value='0'>Mauvaise réponse</option></select></div></div></div>";
    
        divQuestion.append(reponseItem);
    }

    counter++;

    $('.deleteQuestion').click(function(event) {
 
        document.getElementById("questionReponse"+event.target.id).remove();
    
        counter--;
    });
}

$(document).on('click', '.deleteUpdateQuestion', function(event){
    var token = $("meta[name='csrf-token']").attr("content");
    
    $.ajax(
    {
        url: window.location.origin + "/deleteQuestion/" + event.target.id,
        type: 'DELETE',
        dataType: "Text",
        data: {
            "id": event.target.id,
            "_token": token,
        },
        success: function (response)
        {
            console.log('success:' + response);
            
            $("#formUpdateQcm").load(window.location.href + " #questionUpdateQcm");
        },
        error: function(data) 
        {
            console.log(data);
        }
    });
});