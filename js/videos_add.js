var options = {
    type: 'POST',
    url: '/videos/p_add',
    beforeSubmit: function() {
            $('#url-results').html("Saving YT URL info...<br>");
    },
    success: function(response) {
        $('#url-results').html(response);
    },
};

$('form').ajaxForm(options);
