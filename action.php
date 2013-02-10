<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$filename = "lights_db";
$request_type = '';

//  http://home.gajo.us:8484/action.php?cmd=set&sw2=on
// cmd=[list/set]
// sw#=[on/off]

if (isset($_REQUEST['cmd'])) {
	$request_type = trim($_REQUEST['cmd']);
} else {
	print "Error";
	exit();
}

if ($request_type == 'list') {
        status();
    } else if ($request_type == 'set') {
//check session here
	session_start();
	$login_error=1;

        if (session_id()) {
            $id = session_id();
            session_id($id);
        
       		if (isset($_SESSION['card']))
                	$login_error = 0;
        }

	if (isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
		//validate them
		//if good set login_error=0;
		$login_error = 0;
	}

    if( $login_error == 1 )  {
            header("Location: ./index.php?error=1");
        }

        update_info();
    }

////////////////////////////////////////////////////////////////////////////////////////////

function status() {
	global $filename;
	$lights_array = Array();
	//we will always return a full status, even to strangers

	//open db file
        $fp =  fopen($filename,'r');
        if( ! $fp ) {
            print "ERROR cannot find db file $filename\n";
            exit;
        }
	//read through, store as array
     	while( $l = trim(fgets($fp)) ) {
            $ll = explode(',',$l);
		//stick in an array
		$new_array = Array();
		$new_array['id'] = $ll[0];
		$new_array['name'] = $ll[1];
		$new_array['state'] = $ll[2];
		array_push($lights_array, $new_array);
        }
        fclose($fp);

	//return the jsonencoded array
	print json_encode($lights_array);

}

function update_info() {
	
        global $filename;
        $lights_array = Array();
	$login_error = 1;

        $fp =  fopen($filename,'r');
        if( ! $fp ) { 
            print "ERROR cannot find db file $filename\n";
            exit;   
        } 
        $fpo =  fopen($filename . ".out",'a');
        if( ! $fpo ) { 
            print "ERROR cannot open db file $filename.out\n";
            exit;   
        } 

        while( $l = trim(fgets($fp)) ) {
            $ll = explode(',',$l);
                //stick in an array
                $new_array = Array();
                $new_array['id'] = $ll[0]; 
                $new_array['name'] = $ll[1]; 
                $new_array['state'] = $ll[2]; 

		if (isset($_REQUEST[$ll[0]])) {
			if ($_REQUEST[$ll[0]] == 'on') {
				$new_array['state'] = 'i';
			} else {
				$new_array['state'] = 'o';
			}	
			//cmommand to update swX
			$cmd = "switch " . $ll[0] . " " . $_REQUEST[$ll[0]] . " ";
			print exec($cmd);
		}	
		array_push($lights_array, $new_array);
		fwrite($fpo, $new_array['id'] . "," . $new_array['name'] . "," . $new_array['state'] .",\n");	
        }       
//need to copy new file ob=ver old file
        fclose($fp);
	fclose($fpo);
        rename($filename . ".out", $filename);

        //return the jsonencoded array
        print json_encode($lights_array);
}

/*
    function update_info() {

        //loop though the $_GET['$foo'] with the data_collection, handle not setts and nulls
        //add them to a list, then run insertUpdate
        $dob = new DataObject('data_collection');
        $qry = "SELECT field_name FROM data_collection ";
        $dob->setQuery($qry);
        $field = '';
        $field_value = '';
        $field_string = '';
        $return_data = Array();

        while ($dob->fetch()) {
            $field = $dob->getValue('field_name');

		//we will need to save name,id,checked of all

            if (isset($_REQUEST($field))) {
                $field_value = $_REQUEST($field);   
			//here, we should call the system command with sw# and on/off
            }
        }

		//we need to store our updated configuration now

        //check for success
        header('Content-type: application/json');
        $return_data['error'] = 0;
        echo json_encode($return_data);
    }

*/







?>
