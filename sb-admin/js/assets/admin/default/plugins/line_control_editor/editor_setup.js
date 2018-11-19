// This will setup line control editor

// var SERVER = 'http://localhost/links/';
// var BASE_URI = '/links/';

$(document).ready(function(){
	$('.datepicker').datepicker();
	$('.select2').select2();
	$(".select2-tags").select2({
	  tags: true
	})

    $("button:submit").click(function(){
        $('.txteditor').text($('.txteditor').Editor("getText"));
    });

    var body_text = $("#body_text").val();
    var editor = $(".txteditor").Editor();
    $('.txteditor').Editor("setText", body_text);        
})
