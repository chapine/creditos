$(function() {
	load(1);
});



function load(page){
	var query=$("#q").val();
	var per_page= document.getElementById("as").value;
	var parametros = {"action":"ajax","page":page,'query':query,'per_page':per_page};
	
	$("#loader").fadeIn('slow');
	
	$.ajax({
		url: document.getElementById("pagina").value,
		data: parametros,
		 beforeSend: function(objeto){
		$("#loader").html("<img src='../images/loader.gif'> <b>Cargando...</b>");
			 
	  },
		success:function(data){
			$(".outer_div").html(data).fadeIn('slow');
			$("#loader").html("");
		}
	})
}


/*$('#editProductModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  
  var code = button.data('code') 
  $('#edit_code').val(code)
  var name = button.data('name') 
  $('#edit_name').val(name)
  var category = button.data('category') 
  $('#edit_category').val(category)
  var stock = button.data('stock') 
  $('#edit_stock').val(stock)
  var price = button.data('price') 
  $('#edit_price').val(price)
  var id = button.data('id') 
  $('#edit_id').val(id)
})



$('#deleteProductModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') 
  $('#delete_id').val(id)
})



$( "#edit_product" ).submit(function( event ) {
  var parametros = $(this).serialize();
	$.ajax({
		type: "POST",
		url: "editar_producto.php",
		data: parametros,
		
		beforeSend: function(objeto){
			$("#resultados").html("Enviando...");
		},
			
		success: function(datos){
			$("#resultados").html(datos);
			load(1);
			$('#editProductModal').modal('hide');
		}
	});
  event.preventDefault();
});



$( "#add_product" ).submit(function( event ) {
  var parametros = $(this).serialize();
	$.ajax({
			type: "POST",
			url: "guardar_producto.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados").html("Enviando...");
			  },
			success: function(datos){
			$("#resultados").html(datos);
			load(1);
			$('#addProductModal').modal('hide');
		  }
	});
  event.preventDefault();
});



$( "#delete_product" ).submit(function( event ) {
  var parametros = $(this).serialize();
	$.ajax({
			type: "POST",
			url: "eliminar_producto.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados").html("Enviando...");
			  },
			success: function(datos){
			$("#resultados").html(datos);
			load(1);
			$('#deleteProductModal').modal('hide');
		  }
	});
  event.preventDefault();
});*/