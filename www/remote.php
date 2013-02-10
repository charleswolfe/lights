<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
/*
needs
a way to look up user(s)
encode passwords
switch images
https
a way to save state of switches (1-on,2-on,3-off)
a backend (soap) page that actually; retrives swicthes+status, sets a swtitch status


*/
error_reporting(E_ALL);
ini_set('display_errors', '1');

	session_start();
        $login_error = 1;
	if( isset($_REQUEST['username']) && isset($_REQUEST['password']) ) {
            $username = $_REQUEST['username'];
            //$password = encode_password($_REQUEST['password']);
            $card_uid = NULL;
            //$qry = "SELECT cards_uid FROM accounts WHERE email='$username' AND password='$password' ";
            //$dob  = new DataObject('cards');
            //$dob->setQuery($qry);
            //if( $dob->fetch() ) {
            //$card_uid = $dob->getValue('cards_uid');
            $login_error = 0;
//do we need card id at all?
            $_SESSION['card'] = 10001111; //$card_uid;
        //}
        //$dob->destroy();
    }    


        if (session_id()) {
        	$id = session_id();
        	session_id($id);
		if (isset($_SESSION['card']))
                	$login_error = 0;
               	if (isset($_SESSION['redirect'])) {
              		$url = $_SESSION['redirect'];
               		$_SESSION['redirect'] = '';
               		header("Location: " . $url);
              	}
       	}

    	if( $login_error == 1 )  {
            header("Location: ./index.php?error=1");
        }

/*
-loop to populate switches [label][id[checkd] from xml
-state should be okay, but maybe on first load, if somthign is off, see send the off signal
-only update what changed, so we need to keep the state in memory

*/
?>



<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
<link rel="icon" type="image/png" href="images/favicon.png">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
        <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" title="no title" charset="utf-8">
    </head>
<body>



<section class="main">

<table>
        <tr>
        <td>Switch one</td><td align = 'center'><img src="images/led_off.png" class="led" id="sw1led" /></td>
	</tr><tr>
	<td></td>
        <td><img onmousedown="change('sw1on','onpressed')" onmouseup="change('sw1on','onup')" src="images/switch_on_up.png" id="sw1on" class="remoteswitch"  />
	<img onmousedown="change('sw1off','offpressed')" onmouseup="change('sw1off','offup')" src="images/switch_off_up.png" id="sw1off" class="remoteswitch"  /></td>
        </tr>

        <tr>
        <td>Switch two</td><td align="center"><img src="images/led_off.png" class="led" id="sw2led" /></td>
        </tr><tr>
        <td></td>
        <td><img onmousedown="change('sw2on','onpressed')" onmouseup="change('sw2on','onup')" src="images/switch_on_up.png" id="sw2on" class="remoteswitch"  />
	<img onmousedown="change('sw2off','offpressed')" onmouseup="change('sw2off','offup')" src="images/switch_off_up.png" id="sw2off" class="remoteswitch"  /></td>

        </tr>
</table>

</section>



<script type="text/javascript" src="remote.js"></script>
</body>
</html>



