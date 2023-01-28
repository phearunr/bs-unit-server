$(document).ready(function (){ 

    // diable on enter submit form
	$("form.prevent-enter").keypress(function (e) {
	 	var key = e.charCode || e.keyCode || 0;     
		if (key == 13 && e.target.nodeName != "TEXTAREA"  ) {
			e.preventDefault();
		}
	});

    // set Active on main navigation when the url
    var url = window.location;       
    var active_link  =  $('li.nav-item a[href="'+ url +'"]')[0];
    if (active_link != undefined ) {
        $(active_link).closest('li').addClass('active');
    } 

    var full_navigation = $('#main-container').hasClass("container-fluid");
    if (full_navigation) {
    	$("#main-navbar").removeClass('container');
    	$("#main-navbar").addClass('container-fluid');
    }

    // working with ajax for notification
	$('.noti-item .btn-mark-noti-read').click(function (e){
		e.preventDefault();
		var id = $(this).data('id');		
		axios.post('/admin/notifications/'+id+"/markAsRead")
		.then(function (response) {
			// handle success
			console.log(response);
		})
		.catch(function (error) {
			// handle error
			console.log(error);
		})
		.then(function () {
			// always executed
		});
	});

	$('#loader-container').hide();

	//attach loader while making axios call
	axios.interceptors.request.use(function (config) {		
		$('#loader-container').show()
		return config;
	}, function (error) {
		$('#loader-container').hide();
		return Promise.reject(error);
	});

	axios.interceptors.response.use(function (response) {	
		$('#loader-container').hide();
		return response;
	}, function (error) {
		$('#loader-container').hide();
		return Promise.reject(error);
	});

	$('form').submit(function() {	
		if ( $(this).attr('id') == 'unit-export-form') {
			return;
		}		
		$('#loader-container').show();
	});

	$('span.currency').number(true,0);

	$('.currency').number(true,2);

	$('.select2').select2({ theme:"bootstrap4" });

});
