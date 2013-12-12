var options = {
    type: 'POST',
    url: '/users/p_profile',
    beforeSubmit: function() {
            $('#results').html("Uploading avatar...<br>");
    },
    success: function(response) {
        $('#results').html(response);
    },
};

$('form').ajaxForm(options);
/*
$('#refresh-avatar').click(function() {
    $.ajax({
        type: 'POST',
        url: '/users/profile',
        success: function(response) {
            // Parse the JSON results into an array jQuery.parseJSON
            var data = $.parseJSON(response);
            // Inject data into the page
            var $cell = $('#avatar');
            var url = "/uploads/avatars/"+data['avatar_url'];
            $cell.css('background-image', url);
        },
    });
});
*/