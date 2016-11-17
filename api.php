<?php
/**
 * Dynamic Api php.
 * @package    DynamicApiPhp
 * @author     mohammed alimoor <ameral.java@gmail.com>
 */


include 'SimpleOrm.class.php';

//setting database
$Config_DB_Host="localhost";  // Database Host
$Config_DB_Name="test";  // Database  name
$Config_DB_User="root";   // Database user name
$Config_DB_Password="root"; // Database user password

//setting api 
$Config_Required_Auth=FALSE;   //is required Authentication
$Config_Auth_Code="any code";   //Authentication Code
$str = $_POST['request']; //


//-------------------------------------------------------

$json = array();
$json["error"] = FALSE;
$json["message"] = "no error";

$conn = new mysqli($Config_DB_Host, $Config_DB_User, $Config_DB_Password);


if (empty($str)){
	$json["error"] = TRUE;
	$json["message"] = "your  request is empty ";
	printJSon($json);
}


if ($conn->connect_error){
	$json["error"] = TRUE;
	$json["message"] = "Unable to connect to the database.";
	printJSon($json);
}

SimpleOrm::useConnection($conn, $Config_DB_Name);


$obj = json_decode($str);

$obj->action = isset($obj->action)?$obj->action:null;
$obj->auth = isset($obj->auth)?$obj->auth:null;



if (!IsTableHere($conn, @$obj->from)) {
    $json["error"] = TRUE;
    $json["message"] = "Not Found Table : " . @$obj->from;

    printJSon($json);
} 
if($Config_Required_Auth && $Config_Auth_Code != $obj->auth ){
	$json["error"] = TRUE;
	$json["message"] = "Authentication Error Code";
	
	printJSon($json);
}

if ($obj->action == "get") {
    $clname = $obj->from;
    eval("class $clname extends SimpleOrm { }; \$ddd = new $clname();");
    $usr = NULL;
    foreach ($obj->data as $key => $val) {
        if ($key == $obj->key) {
            $usr = @$ddd::retrieveByField($key, $val)[0];
        }
    }


    // $usr->save();
    $json["error"] = FALSE;
    $json["message"] = "Get Row Table by " . $obj->key;
    $json["data"] = $usr;

    printJSon($json);
}
else if ($obj->action == "all") {
	$clname = $obj->from;
	eval("class $clname extends SimpleOrm { }; \$ddd = new $clname();");
	$usr = NULL;
	$usr = $ddd::all();


	
	$json["error"] = FALSE;
	$json["message"] = "get All Data";
	$json["data"] = $usr;
	
	printJSon($json);
}
// to search  'like ' must to use "%" value in data json  ex: 

else if ($obj->action == "search") {
    $clname = $obj->from;
    eval("class $clname extends SimpleOrm { }; \$ddd = new $clname();");
    $usr = NULL;
    foreach ($obj->data as $key => $val) {
        
        if ($key == $obj->key) {
           // print_r($ddd::retrieveByField($key, $val));
            $usr = @$ddd::retrieveByField($key, "%".$val."%");
        }
    }


    // $usr->save();
    $json["error"] = FALSE;
    $json["message"] = "Get Row Table by " . $obj->key;
    $json["data"] = $usr;

    printJSon($json);
}

else if ($obj->action == "add") {
    $clname = $obj->from;
    eval("class $clname extends SimpleOrm { }; \$cls = new $clname();");
    foreach ($obj->data as $key => $val) {
        $cls->{$key} = $val;
    }
    $cls->save();
    $json["error"] = FALSE;
    $json["message"] = "Add Done";
    printJSon($json);
} else if ($obj->action == "edit") {
    $clname = $obj->from;
    eval("class $clname extends SimpleOrm { }; \$ddd = new $clname();");
    $usr = NULL;
    foreach ($obj->data as $key => $val) {
        if ($key == $obj->key) {
            $usr = $ddd::retrieveByField($key, $val)[0];
        }
    }

    foreach ($obj->data as $key => $val) {
        $usr->{$key} = $val;
    }

    $usr->save();
    // $usr->save();
    $json["error"] = FALSE;
    $json["message"] = "Edit Done";
    printJSon($json);
} else if ($obj->action == "delete") {
    $clname = $obj->from;
    eval("class $clname extends SimpleOrm { }; \$ddd = new $clname();");
    $usr = NULL;
    foreach ($obj->data as $key => $val) {
        if ($key == $obj->key) {
            $usr = $ddd::retrieveByField($key, $val)[0];
        }
    }

    foreach ($obj->data as $key => $val) {
        $usr->{$key} = $val;
    }
    $usr->delete();
    $json["error"] = FALSE;
    $json["message"] = "Delete Done";
    printJSon($json);
}

else{
    
     $json["error"] = TRUE;
    $json["message"] = "Not Found Action :" . @$obj->action;

    printJSon($json);
}

function IsTableHere($conn, $tableName) {
    if (mysqli_num_rows(mysqli_query($conn, "SHOW TABLES LIKE '" . $tableName . "'")) == 1)
        return TRUE;
    else
        return FALSE;
}

function printJSon($Json) {
    echo json_encode($Json);
    exit();
}
