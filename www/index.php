<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php session_start();
if(isset($_SESSION['redirect'])) {
        $url = $_SESSION['redirect'];
}
        session_destroy();
	session_start();
if(isset($url))
    $_SESSION['redirect'] = $url;
?>
<head>
	<link rel="icon" type="image/png" href="images/favicon.png">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" title="no title" charset="utf-8">
    
    <title>Lights</title>

    <script>
        function local_submit() {
            if( document.getElementById('username').value.length == 0 )
                return false;

            if( document.getElementById('password').value.length == 0 )
                return false;

            return true;
        }

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '',
      status     : true,
      cookie     : true,
      xfbml      : true
    });

   // listen for and handle auth.statusChange events
        FB.Event.subscribe('auth.statusChange', function(response) {
          if (response.authResponse) {

           FB.api('/me', function(me){
                var path = 'remote.php';
                var method = method || "post";
                var form = document.createElement("form");
                form.setAttribute("method", method);
                form.setAttribute("action", path);

                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", 'fbid');
                hiddenField.setAttribute("value", me.id);
                form.appendChild(hiddenField);

                if(me.email) {
                        var hiddenField = document.createElement("input");
                        hiddenField.setAttribute("type", "hidden");
                        hiddenField.setAttribute("name", 'fbuser');
                        hiddenField.setAttribute("value", me.email);
                        form.appendChild(hiddenField);
                } else {
                        alert("ERROR: Email address permissions are required!");        
                }

                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", 'fbauthtoken');
                hiddenField.setAttribute("value", response.authResponse.accessToken);
                form.appendChild(hiddenField);

                document.body.appendChild(form);
                form.submit();
            })
          } else {
                // user has not auth'd your app, or is not logged into Facebook
                //here, maybe call a web page that deletes the users auth token if it exists?   
                //or do we always assume its a new user, not one who deauthed us?
          }
        });
  };

  // Load the SDK Asynchronously
  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));
        </script>
        
</head>

<body>


<div id="wrapper">


       <!-- /////////////// Top Menu /////////////// -->
                <div id="top_menu">
			<img src="images/logo.gif" > <!--style="width:90%;height:90%;>-->
                </div>

        <!-- /////////////// Content /////////////// -->

    <div id="content">


        <div class="clear">
        <div id="login_left">
            <form action="remote.php" method="post" onsubmit="return local_submit();" accept-charset="utf-8">
                <table border="0">
                    <tr>
                        <th>Who</th>
                    </tr>

                    <tr>
                        <td>
                            <input type="text" name="username" id="username" size="32" maxlength="64" value="">
                        </td>
                    </tr>
                    <tr>
                        <th>Secret word</th>
                    </tr>

                    <tr>
                        <td>
                            <input type="password" name="password" id="password" size="16" maxlength="16" value="">
                        </td>
                    </tr>

                    <tr>
                        <td>
<?php if(isset($_REQUEST['error'])) {
           if ($_REQUEST['error'] == 1) { ?>
                            <p class="error">Error 1 occured</p>
<?php } else if ($_REQUEST['error'] == 2) { ?>
                            <p class="error">facebook error You must link your account fist</p>
                            <p class="error">Log in as usual and vist 'Edit Information'</p>
<?php      } } ?>
                            <input type="submit" name="some_name" value="Login" id="login">
                        </td>
                    </tr>

                    <tr>
                                <td align="right">
                           <div class="fb-login-button" data-show-faces="false" perms="email,publish_stream,user_likes" data-width="200" data-max-rows="1"></div>

                        </td>

                    </tr>
                    <tr>
                        <td align="center">
                            <div class="tw-login-button" >
<!--                            <a href="./twredirect.php?mode=signin"><input type="button"  name="tw-login-button" width="104px"value="" id="tw-login-button"></a>
 -->
                            </div>
                        </td>
                    </tr>

                </table>
            </form>
        </div>

        <div id="login_right">
        </div>
    </div>
</div>
</body>
</html>

