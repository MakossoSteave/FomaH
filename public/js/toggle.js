$(document).on('click', '.showFileProject', function () {
    $('.showFileProject').hide();
    $('#projectShowFileLink').slideToggle("fast");
});

$(document).on('click', '.correctionShow', function (event) {
    $('#correctionToggle'+event.target.id).slideToggle("fast");
});