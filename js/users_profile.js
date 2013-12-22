var options = {
    type: 'POST',
    url: '/users/p_profile',
    beforeSubmit: function() {
            $('#results').html("Uploading avatar...<br>");
    },
    success: function(response) {
        $('#results').html(response);
        setTimeout(function() {location.reload();}, 2000);
    },
};

$('form').ajaxForm(options);