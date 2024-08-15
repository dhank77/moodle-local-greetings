define(['jquery', 'core/ajax'], function($, ajax) {
    return {
        init: function() {
            $('#message-form').on('submit', function(e) {
                e.preventDefault();
                var message = $('#message').val();
                var promise = ajax.call([
                    {
                        methodname: 'local_greetings_save_message',
                        args: { message: message }
                    }
                ]);
                promise.done(function(response) {
                    if (response.status === 'success') {
                        alert('Message saved successfully!');
                    } else {
                        alert('An error occurred.');
                    }
                }).fail(function() {
                    alert('AJAX request failed.');
                });
            });
        }
    };
});
