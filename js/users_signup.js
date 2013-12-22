$('input[name="first_name"]').click(function() {
    var label = $(this).next();
    var msg = "First Name: Min Length: 1 char, max 12.";
    $('#output').html(msg);
});

$('input[name="last_name"]').click(function() {
    var label = $(this).next();
    var msg = "Last Name: Min Length 3, max 12.";
    $('#output').html(msg);
});

$('input[name="password"]').click(function() {
    var label = $(this).next();
    var msg = "Password: Min Length 6, max 12.";
    $('#output').html(msg);
});

$('input[name="email"]').click(function() {
    var label = $(this).next();
    var msg = "Email: will be used for login.";
    $('#output').html(msg);
});

$(function(){

	var form	= $('form');
	var submit 	= $('#submit');
	var alert	= $('.alert');

	// validate form
	form.validate({
		// validation rules
		rules: {
			// first name field (required , minimum length 1, max 12)
			first_name: {
				required: true,
				minlength: 1,
				maxlength: 12,
			},
			// last_name field (required , minimum length 3, max 12)
			last_name: {
				required: true,
				minlength: 3,
				maxlength: 12,
			},
			// password field (required , minimum length 6, max 12)
			password: {
				required: true,
				minlength: 6,
				maxlength: 12
			},
			// email field only required
			email: {
				required: true,
			}
		},
		ignore: ":hidden"
	});
});

var options = { 
	type: 'POST',
	url: '/users/p_signup/',
	beforeSubmit: function() {
		$('#output').html("Adding...");
	},
	success: function(response) { 
		// Let's inject that data into the page 
		$('#output').html(response);
		if (response === "Congratulation") {
			$('#output').append("... Going to Profile page in 1 seconds!");
			setTimeout(function() {
  				window.location.href = "/users/profile";
				}, 1000);
		}
		else {
			//window.location.href = "/users/signup";
			$('#output').append("... Please try again.");
		}
	}, 
};

$('form').ajaxForm(options);

