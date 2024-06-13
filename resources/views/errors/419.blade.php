<!DOCTYPE html>
<html>

<head>
    <title>Session Timeout Template</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>

<body>
    <!-- START: CSS Data -->
    <style>
        div#message-timeout {
            position: fixed;
            left: 0px;
            top: 0px;
            z-index: 1050;
        }

        div#timeout-warning {
            background: #f7941e;
            border: 3px solid #f0ad4e;
            color: #fff;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            padding: 10px;
        }

        div#timeout-error {
            background: red;
            border: 3px solid #f0ad4e;
            color: #fff;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            padding: 10px;
        }
    </style>
    <!-- END: CSS Data -->

    <!-- START: HTML Data -->
    <div id="message-timeout">
        <div id="timeout-warning" style="display:none;">
            <strong>Warning:</strong> You will be logged off in <strong id="timeoutCounter">0</strong> seconds due to
            inactivity.

            <button class="SessionRefresh">Click here to stay logged in.</button>
        </div>
        <div id="timeout-error" style="display:none;">
            <strong>Your session has expired due to inactivity.</strong>
        </div>
    </div>
    <!-- END: HTML Data -->

    <!-- Start: JS Data -->
    <script>
        $(document).ready(function() {
            var date = new Date();
            var sessionLength = 20; //Session lengh in minutes
            var sessionWarning = 90000; //In milliseconds

            if (typeof(Storage) !== "undefined") //Browser support for Local Storage
            {
                localStorage.sessionTimeout = new Date(date.getTime() + sessionLength * 60000);
                localStorage.lastActivity = date;
                var counter = setInterval(function() {
                    var lastActivity = new Date(localStorage.lastActivity);
                    var sessionTimeout = new Date(localStorage.sessionTimeout);
                    var currentTime = new Date();
                    var idleTime = Math.floor((currentTime.getTime() - lastActivity.getTime()) / 1000);
                    var diff = Math.floor((sessionTimeout.getTime() - currentTime.getTime()) / 1000);

                    if (currentTime >= sessionTimeout) {
                        clearInterval(counter);
                        $("#timeout-warning").hide();
                        $("#timeout-error").show();
                        return;
                    } else if (currentTime >= (sessionTimeout - sessionWarning)) {
                        $("#timeout-error").hide();
                        $("#timeout-warning").show();
                        $("#timeoutCounter").html(diff);
                        $("#idleTime").html(toHHMMSS(idleTime));
                    } else {
                        $("#timeout-error").hide();
                        $("#timeout-warning").hide();
                    }
                }, 1000); //1000 will  run it every 1 second
            }

            $("#message-timeout").on('click', '.SessionRefresh', function(e) {
                //Ajax call or something to refesh the session.
                $.ajax({
                    url: "RALookup/_RefreshSession",
                    cache: false
                });
            });

        });
        $(document).ajaxSuccess(function(event, request, settings) {
            var date = new Date();
            localStorage.lastActivity = date;
            localStorage.sessionTimeout = new Date(date.getTime() + 20 * 60000);
        });
    </script>
    <!-- END: JS Data -->

</body>

</html>
