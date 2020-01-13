$(function () {
    "use strict";

    // for better performance - to avoid searching in DOM
    var content = $('#chat');
    var input = $('#chat_input');
    var status = $('#status');

    // my color assigned by the server
    var myColor = false;
    // my name sent to the server
    var myName = false;

    // if user is running mozilla then use it's built-in WebSocket
    window.WebSocket = window.WebSocket || window.MozWebSocket;

    // if browser doesn't support WebSocket, just show some notification and exit
    if (!window.WebSocket) {
        content.html($('<p>', {
            text: 'Sorry, but your browser doesn\'t '
                + 'support WebSockets.'
        }));
        input.hide();
        $('span').hide();
        return;
    }

    // open connection
    var connection = new WebSocket('ws://localhost:8080');

    connection.onopen = function () {
        // first we want users to enter their names
        input.removeAttr('disabled');
        status.text('your text:');
    };

    connection.onerror = function (error) {
        // just in there were some problems with conenction...
        content.html($('<p>', {
            text: 'Sorry, but there\'s some problem with your '
                + 'connection or the server is down.'
        }));
    };

    // most important part - incoming messages
    connection.onmessage = function (message) {
        addMessageRecieved("", message.data, "", new Date(null));
    };

    /**
     * Send mesage when user presses Enter key
     */
    input.keydown(function (e) {
        if (e.keyCode === 13) {
            var msg = $(this).val();
            if (!msg) {
                return;
            }
            // send the message as an ordinary text

            connection.send(msg);
            addMessageSent("", msg, "", new Date(null));


            $(this).val('');
// disable the input field to make the user wait until server
// sends back response

// we know that the first message sent from a user their name
            if (myName === false) {
                myName = msg;
            }
        }
    });


    /**
     * Add message to the chat window
     */
    function addMessageSent(author, message, color, dt) {
        content.prepend('<div class="msg alert-success text-right "><span style="color:' + color + '">' + author + '</span> @ ' +
            +(dt.getHours() < 10 ? '0' + dt.getHours() : dt.getHours()) + ':'
            + (dt.getMinutes() < 10 ? '0' + dt.getMinutes() : dt.getMinutes())
            + ': ' + message + '</div>');
    }


    function addMessageRecieved(author, message, color, dt) {
        content.prepend('<div class="msg alert-danger text-left "><span style="color:' + color + '">' + author + '</span> @ ' +
            +(dt.getHours() < 10 ? '0' + dt.getHours() : dt.getHours()) + ':'
            + (dt.getMinutes() < 10 ? '0' + dt.getMinutes() : dt.getMinutes())
            + ': ' + message + '</div>');
    }
});