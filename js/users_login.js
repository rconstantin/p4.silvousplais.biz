var options = {
    type: 'POST',
    url: '/users/p_login/',
    beforeSubmit: function() {
            $('#output').html("Login In Progress...<br>");
    },
    success: function(response) {

        $('#output').html(response);
        // setTimeout(function() {location.reload();}, 5000);
        if (response == "Success") {
            $('#output').append("... Going to Home page in 1 seconds!");
            setTimeout(function() {
            window.location.href = "/";
            }, 1000);
        }
        else {
            $('#output').append("... Please try again.");
        }
    },
};

$('form').ajaxForm(options);