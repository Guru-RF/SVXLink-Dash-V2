<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <link href="/css/css.php" type="text/css" rel="stylesheet" />
<style type="text/css">
body {
  background-color: #eee;
  font-size: 18px;
  font-family: Arial;
  font-weight: 300;
  margin: 2em auto;
  max-width: 40em;
  line-height: 1.5;
  color: #444;
  padding: 0 0.5em;
}
h1, h2, h3 {
  line-height: 1.2;
}
a {
  color: #607d8b;
}
.highlighter-rouge {
  background-color: #fff;
  border: 1px solid #ccc;
  border-radius: .2em;
  font-size: .8em;
  overflow-x: auto;
  padding: .2em .4em;
}
pre {
  margin: 0;
  padding: .6em;
  overflow-x: auto;
}

#player {
    position:relative;
    width:205px;
    overflow: hidden;
    direction: ltl;
}

textarea {
    background-color: #111;
    border: 1px solid #000;
    color: #ffffff;
    padding: 1px;
    font-family: courier new;
    font-size:10px;
}




</style>
</head>
<body style="background-color: #e1e1e1;font: 11pt arial, sans-serif;">
<center>
<fieldset style="border:#3083b8 2px groove;box-shadow:0 0 10px #999; background-color:#f1f1f1; width:555px;margin-top:15px;margin-left:0px;margin-right:5px;font-size:13px;border-top-left-radius: 10px; border-top-right-radius: 10px;border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
<div style="padding:0px;width:550px;background-image: linear-gradient(to bottom, #e9e9e9 50%, #bcbaba 100%);border-radius: 10px;-moz-border-radius:10px;-webkit-border-radius:10px;border: 1px solid LightGrey;margin-left:0px; margin-right:0px;margin-top:4px;margin-bottom:0px;line-height:1.6;white-space:normal;">
<center>
<h1 id="echolink" style="color:#00aee8;font: 18pt arial, sans-serif;font-weight:bold; text-shadow: 0.25px 0.25px gray;">EchoLink Configurator</h1>


<?php 
function build_ini_string(array $a) {
    $out = '';
    $sectionless = '';
    foreach($a as $rootkey => $rootvalue){
        if(is_array($rootvalue)){
            // find out if the root-level item is an indexed or associative array
            $indexed_root = array_keys($rootvalue) == range(0, count($rootvalue) - 1);
            // associative arrays at the root level have a section heading
            if(!$indexed_root) $out .= PHP_EOL."[$rootkey]".PHP_EOL;
            // loop through items under a section heading
            foreach($rootvalue as $key => $value){
                if(is_array($value)){
                    // indexed arrays under a section heading will have their key omitted
                    $indexed_item = array_keys($value) == range(0, count($value) - 1);
                    foreach($value as $subkey=>$subvalue){
                        // omit subkey for indexed arrays
                        if($indexed_item) $subkey = "";
                        // add this line under the section heading
                        $out .= "{$key}[$subkey] = $subvalue" . PHP_EOL;
                    }
                }else{
                    if($indexed_root){
                        // root level indexed array becomes sectionless
                        $sectionless .= "{$rootkey}[] = $value" . PHP_EOL;
                    }else{
                        // plain values within root level sections
                        $out .= "$key = $value" . PHP_EOL;
                    }
                }
            }

        }else{
            // root level sectionless values
            $sectionless .= "$rootkey = $rootvalue" . PHP_EOL;
        }
    }
    return $sectionless.$out;
}


$elConfigFile = '/etc/svxlink/svxlink.d/ModuleEchoLink.conf';
if (fopen($elConfigFile,'r'))
      {
          $elconfig = parse_ini_file($elConfigFile,true,INI_SCANNER_RAW);
      };
  $logics = explode(" ",$elconfig['A']);
  foreach ($logics as $key) {
//if ($logics[0] == "[ModuleEchoLink]") $isEchoLink = true;


   //isset($_POST['btnSave']);
    $retval = null;
    $screen = null;


    $elconfig['DEFAULT_LANG'] = $_POST['inElDefaultLang'];
    $elconfig['CALLSIGN'] = $_POST['inElCallsign'];
    $elconfig['PASSWORD'] = $_POST['inElPassword'];
    $elconfig['SYSOPNAME'] = $_POST['inElSysOpName'];
    $elconfig['LOCATION'] = $_POST['inElLocation'];

    $elconfig['SERVERS'] = $_POST['inElServers'];
    $elconfig['PROXY_SERVER'] = $_POST['inElProxyServer'];
    $elconfig['PROXY_PORT'] = $_POST['inElProxyPort'];
    $elconfig['PROXY_PASSWORD'] = $_POST['inElProxyPassword'];

    $elconfig['DESCRIPTION'] = $_POST['inElDescription'];


    $elconfig['MUTE_LOGIC_LINKING'] = $_POST['inElMuteLogicLinking'];
  }
        $ini = build_ini_string($elconfig);

        //file_put_contents("/var/www/html/test.ini",$ini,FILE_USE_INCLUDE_PAT);
        file_put_contents("/var/www/html/echolink/ModuleEchoLink.conf", $ini ,FILE_USE_INCLUDE_PATH);

	///file manipulation section

      	$retval = null;
        $screen = null;
	//archive the current config
	exec('sudo cp /etc/svxlink/svxlink.d/ModuleEchoLink.conf /etc/svxlink/svxlink.d/ModuleEchoLink.conf.' .date("YmdThis") ,$screen,$retval);
	//move generated file to current config
	exec('sudo mv /var/www/html/echolink/ModuleEchoLink.conf /etc/svxlink/svxlink.d/ModuleEchoLink.conf', $screen, $retval);

  //Service SVXlink restart
  exec('sudo service svxlink restart 2>&1',$screen,$retval);



//debug
//      echo '<pre>';
 //     print_r($ini);
 //     echo '</pre>';
//end of debug

}


//if (fopen($svxConfigFile,'r'))
//      {

//        $elconfig = parse_ini_file($svxConfigFile,true,INI_SCANNER_RAW);
//};

//$svxConfigFile = '/etc/svxlink/svxlink.conf';
//$svxConfigFile = '/var/www/html/svxlink.conf';    






//if (fopen($elConfigFile,'r'))
  //    { 

//	$elconfig = parse_ini_file($elConfigFile,true,INI_SCANNER_RAW);
        
	      $inElDefaultLang = $elconfig['DEFAULT_LANG'];
        $inElCallsign = $elconfig['CALLSIGN'];
        $inElPassword = $elconfig['PASSWORD'];
        $inElSysOpName = $elconfig['SYSOPNAME'];
        $inElLocation = $elconfig['LOCATION'];
        $inElServers = $elconfig['SERVERS'];
        $inElProxyServer =  $elconfig['PROXY_SERVER'];
        $inElProxyPort = $elconfig['PROXY_PORT'];
        $inElProxyPassword = $elconfig['PROXY_PASSWORD'];
        $inElMuteLogicLinking = $elconfig['MUTE_LOGIC_LINKING'];

//}
//    else { $callsign="N0CALL";}



//if ($_SERVER["REQUEST_METHOD"] == "POST") {
//  if (empty($_POST["ssid"])) {
//     echo "Name is required";
//  } else {
//    $ssid = $_POST["ssid"]);
//  }
//}}


// load the connlist
$retval = null;
$conns = null;
// find the gateway
//tbc - load the data from ini RF.

?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">


<table>
        <tr>
        <th width = "380px">Echolink Input</th>
        <th width = "100px">Action</th>
        </tr>
<tr>
<TD>
        <Table style="border-collapse: collapse; border: none;">
        <tr style="border: none;">
                <th width = "30%"></th>
                <th width = "70%"></th>
        </tr>
        <tr style="border: none;"> 
        <td style="border: none;">Default Language</td>
        <td style="border: none;"><input type="text" name="inElDefaultLang" style="width:98%" value="<?php echo $inElDefaultLang;?>"></td>
        </tr>
        <tr style="border: none;"> 
        <td style="border: none;">Callsign</td>
        <td style="border: none;"><input type="text" name="inElCallsign" style="width:98%" value="<?php echo $inElCallsign;?>">
        </td></tr>
        <tr style="border: none;"> 
        <td style="border: none;">Password</td>
        <td style="border: none;"><input type="text" name="inElPassword" style="width:98%" value="<?php echo $inElPassword;?>">
        </td></tr>
        <tr style="border: none;"> 
        <td style="border: none;">SysOp Name</td>
        <td style="border: none;"><input type="text" name="inElSysOpName" style="width:98%" value="<?php echo $inElSysOpName;?>">
        </td></tr>
        <tr style="border: none;"> 
        <td style="border: none;">Location</td>
        <td style="border: none;"><input type="text" name="inElLocation" style="width:98%" value="<?php echo $inElLocation;?>">
        </td></tr>
        <!--<tr style="border: none;"> 
        <td style="border: none;">Description</td>
        <td style="border: none;"><input type="text" name="inElDescription" style="width:98%" value="<?php echo $inElDescription;?>">
        </td></tr>-->
        <tr style="border: none;"> 
        <td style="border: none;">Servers</td>
        <td style="border: none;"><input type="text" name="inElServers" style="width:98%" value="<?php echo $inElServers;?>">
        </td></tr>
        <tr style="border: none;"> 
        <td style="border: none;">Proxy Server</td>
        <td style="border: none;"><input type="text" name="inElProxyServer" style="width:98%" value="<?php echo $inElProxyServer;?>">
        </td></tr>
        <tr style="border: none;"> 
        <td style="border: none;">Proxy Port</td>
        <td style="border: none;"><input type="text" name="inElProxyPort" style="width:98%" value="<?php echo $inElProxyPort;?>">
        </td></tr>
        <tr style="border: none;"> 
        <td style="border: none;">Proxy Password</td>
        <td style="border: none;"><input type="text" name="inElProxyPassword" style="width:98%" value="<?php echo $inElProxyPassword;?>">
        </td></tr>
        <tr style="border: none;"> 
        <td style="border: none;">Mute Logic Linking</td>
        <td style="border: none;"><input type="text" name="inElMuteLogicLinking" style="width:98%" value="<?php echo $inElMuteLogicLinking;?>">
        </td></tr>
        </Table>


</TD>
<td>
        <button name="btnSave" type="submit" class="red" style="height:100px; width:105px; font-size:12px;">Save <BR><Br> & <BR><BR> ReLoad</button>
</td>

</tr>
</table>




</form>

<p style="margin: 0 auto;"></p>
<p style="margin-bottom:-2px;"></p>

</body>
</html>
