//[Dashboard Javascript]

//Project:  Fox Admin - Responsive Admin Template

//Primary use:   Used only for the main dashboard 

$(function () {

  'use strict';
	
	//ticker
		if ($('#webticker-1').length) {   
			$("#webticker-1").webTicker({
				height:'auto', 
				duplicate:true, 
				startEmpty:false, 
				rssfrequency:5
			});
		}
	//data table
		$('#example1').DataTable({
		  'paging'      : false,
		  'lengthChange': false,
		  'searching'   : false,
		  'ordering'    : true,
		  'info'        : false,
		  'autoWidth'   : false
		});

	
}); // End of use strict