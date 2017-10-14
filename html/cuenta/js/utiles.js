$(document).ready(function(){
	$("#acordion div.bloque-acordion").hide();
	$("#acordion h3").click(function(){
	$(this).next("div.bloque-acordion").slideToggle("fast")
	.siblings("div.bloque-acordion:visible").slideUp("fast");
	$(this).toggleClass("activo");
	$(this).siblings("h3").removeClass("activo");
	});
});

$().ready(function() {
	$("#razonsocial_form").validate();
	$("#datosfacturacion_form").validate();
	$("#mediopago_form").validate();
});