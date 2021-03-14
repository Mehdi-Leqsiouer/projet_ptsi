$(document).ready(function() {

    // process the form
    $('formName').submit(function(event) {
        event.preventDefault();
        // get the form data
        // there are many ways to get this data using jQuery (you can use the class or id also)
        var formData = {
            'name'              : $('input[name=name]').val(),
            'email'             : $('input[name=email]').val(),
            'phone'             : $('input[name=phone]').val(),
            'message'             : $('input[name=message]').val()
        };

        // process the form
        $.ajax({
            type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'send_contact.php', // the url where we want to POST
            data        : formData // our data object
        })
            // using the done promise callback
            .done(function(data) {

                // log data to the console so we can see
                console.log(data);
                alert("ok");
                if (!data.success) {
                    console.log("erreur");
                }
                else{
                    $('formName').html('<div class="alert alert-success">' + data.message + '</div>');
                }

                // here we will handle errors and validation messages
            }).fail(function() {
                alert("erreur");
        })
        ;

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
    });

});