$(document).ready(function()
{
	/* AJAX PAGINATION */
	$("#select_download_product").change(function(e)
	{
		/* je recupere la valeur du select */
		valeur = $(this).val(); 
		// Difficulte a recuperer l'URL, du coup j'utilise cette'ritournelle pour la récupérer dans un champs hidden mis dans le tpl !
		var downloadpage_link = $('#downloadpage_link').val();
		console.log(downloadpage_link); 
		$.ajax({
		  type: 'GET',
		  url: downloadpage_link,
		headers: { "cache-control": "no-cache" },
		async: true,
		cache: false,
		  data: 'ajax=true&id_product='+valeur,
			  success: function(data) {
		    $('#list_product_download').html(data); // update the DIV
		  },
		  error: function(){
		  	console.log('error ajax');
		  }

		});
	});

});
