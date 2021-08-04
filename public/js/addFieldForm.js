var counter = 0;

function addQuestion(){

    var addQuestion = $("#addQuestion");

    addQuestion.append("<div class='field idUpdate' id='questionReponse"+counter+"'></div>");

    var divQuestion = $("#questionReponse"+counter);

    var buttonDeleteQuestion = "<div class='flex'><div></div><div class='mt-2 mb-2'><a id='"+counter+"' class='has-icons-right has-text-danger deleteQuestion'>Supprimer la question<span class='icon is-small is-right'><i class='fas fa-trash-alt'></i></span></a></div></div>";

    divQuestion.append(buttonDeleteQuestion);

        var questionItem = "<div class='field' id='questions'><label class='label'>Question</label><div class='control'><input name='qcm["+counter+"][question]' class='input' type='text' placeholder='Question'></div></div><div class='field' id='explications'><label class='label'>Explication</label><div class='control'><textarea name='explication[]' class='textarea' type='text' placeholder='Explication'></textarea></div></div>";

    divQuestion.append(questionItem);

    for (var index = 0; index < 4; index++) {
        var reponseItem = "<div class='field' id='reponses"+counter+"'><label class='label'>Réponse</label><div class='control'><input name='qcm["+counter+"][reponse"+index+"]' class='input' type='text' placeholder='Réponse'></div></div><div class='field'><label class='label'>Choisir la validation de la réponse</label><div class='control'><div class='select'><select name='qcm["+counter+"][validation"+index+"]'><option value='1'>Bonne réponse</option><option value='0'>Mauvaise réponse</option></select></div></div></div>";
    
        divQuestion.append(reponseItem);
    }

    counter++;

    $(document).on('click', '.deleteQuestion', function (event) {
 
        $("#questionReponse"+event.target.id).remove();

        $("#reponses"+event.target.id).remove();
    
        $(".idUpdate").each(function(index) {
            var prefix = "qcm[" + index + "]";
            $(this).find("input").each(function() {
               this.name = this.name.replace(/qcm\[\d+\]/, prefix);   
            });
            $(this).find("select").each(function() {
                this.name = this.name.replace(/qcm\[\d+\]/, prefix);   
             });
        });
    
        if (counter > 0) {
            counter--;   
        }
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

function addSection(){

    var addQuestion = $("#addSection");

    addQuestion.append("<div class='field idUpdate' id='section"+counter+"'></div>");

    var divQuestion = $("#section"+counter);

    var buttonDeleteSection = "<div class='flex'><div></div><div class='mt-2 mb-2'><a id='"+counter+"' class='has-icons-right has-text-danger deleteSection'>Supprimer la section<span class='icon is-small is-right'><i class='fas fa-trash-alt'></i></span></a></div></div>";

    divQuestion.append(buttonDeleteSection);

        var sectionItem = "<div class='field'><label class='label'>Titre de la section</label><div class='control'><input name='section["+counter+"][designation]' class='input' type='text' placeholder='Titre de la section'></div></div><div class='field'><label class='label'>Contenu</label><div class='control'><textarea name='section["+counter+"][contenu]' class='textarea' type='text' placeholder='Contenu'></textarea></div></div><div class='field'><label class='label'>Ajouter une image</label><div id='file-js-image-cours-"+counter+"' class='file has-name'><label class='file-label'><input class='file-input' type='file' name='section["+counter+"][image]'><span class='file-cta'><span class='file-icon'><i class='fas fa-upload'></i></span><span class='file-label'>Choisir un image</span></span><span class='file-name'>Aucune image</span></label></div></div>";

    divQuestion.append(sectionItem);

    var fileInput = $("#file-js-image-cours-"+counter+" input[type=file]");

    fileInput.change = () => {
        if (fileInput.files.length > 0) {
        var fileName = $("#file-js-image-cours-"+counter+" .file-name");
        fileName.text(fileInput.files[0].name);
        }
    }

    counter++;

    $(document).on('click', '.deleteSection', function (event) {
 
        $("#section"+event.target.id).remove();
    
        $(".idUpdate").each(function(index) {
            var prefix = "section[" + index + "]";
            $(this).find("input").each(function() {
               this.name = this.name.replace(/section\[\d+\]/, prefix);   
            });
            $(this).find("textarea").each(function() {
                this.name = this.name.replace(/section\[\d+\]/, prefix);   
             });
        });
    
        if (counter > 0) {
            counter--;   
        }
    });
}

$(document).on('click', '.deleteUpdateSection', function(event){
    var token = $("meta[name='csrf-token']").attr("content");
    
    $.ajax(
    {
        url: window.location.origin + "/deleteSection/" + event.target.id,
        type: 'DELETE',
        dataType: "Text",
        data: {
            "id": event.target.id,
            "_token": token,
        },
        success: function (response)
        {
            console.log('success:' + response);
            
            $("#formUpdateSection").load(window.location.href + " #questionUpdateSection");
        },
        error: function(data) 
        {
            console.log(data);
        }
    });
});