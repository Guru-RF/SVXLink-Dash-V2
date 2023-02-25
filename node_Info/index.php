<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" lang="en">
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
.button {
  border: none;
  color: #454545;
  padding: 16px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
}
.buttonh {
  background-image: linear-gradient(to bottom, #337ab7 0%, #265a88 100%);color:#454545;
  color: #454545;
}

.buttonh:hover {
  background-color: #4CAF50;
  color: #454545;
}
.green
{
  background-color: #448f47;
  border: none;
  color: white;
  font-weight: 600;
  font-size: 13px;
  padding: 4px 12px;
  text-decoration: none;
  margin: 4px 4px;
  cursor: pointer;
  border-radius: 4px;

}

.blue
{
  background-image: linear-gradient(to bottom, #337ab7 0%, #265a88 100%);color:#454545;
  border: none;
  color: white;
  font-weight: 600;
  font-size: 16px;
  padding: 4px 12px;
  text-decoration: none;
  margin: 4px 4px;
  cursor: pointer;
  border-radius: 4px;
  height:80px;
  width:150px;
}

.red
{
  background-color: #b00;
  border: none;
  color: white;
  font-weight: 600;
  font-size: 13px;
  padding: 4px 12px;
  text-decoration: none;
  margin: 4px 4px;
  cursor: pointer;
  border-radius: 4px;
}
.orange
{
  background-color: DarkOrange;
  border: none;
  color: white;
  font-weight: 600;
  font-size: 13px;
  padding: 4px 12px;
  text-decoration: none;
  margin: 4px 4px;
  cursor: pointer;
  border-radius: 4px;
}
.purple
{
  background-color: #800080;
  border: none;
  color: white;
  font-weight: 600;
  font-size: 13px;
  padding: 4px 12px;
  text-decoration: none;
  margin: 4px 4px;
  cursor: pointer;
  border-radius: 4px;
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
<fieldset style="border:#3083b8 2px groove;box-shadow:5px 5px 20px #999; background-color:#f1f1f1; width:555px;margin-top:15px;margin-left:0px;margin-right:5px;font-size:13px;border-top-left-radius: 10px; border-top-right-radius: 10px;border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
<div style="padding:0px;width:550px;background-image: linear-gradient(to bottom, #e9e9e9 50%, #bcbaba 100%);border-radius: 10px;-moz-border-radius:10px;-webkit-border-radius:10px;border: 1px solid LightGrey;margin-left:0px; margin-right:0px;margin-top:4px;margin-bottom:0px;line-height:1.6;white-space:normal;">

<!--h1 id="edit_info" style="color:#00aee8;font: 18pt arial, sans-serif;font-weight:bold; text-shadow: 0.25px 0.25px gray;">Edit Configuration '. $_GET['file']'</h1-->
<?php //echo '<h1 id="edit_info" style="color:#00aee8;font: 18pt arial, sans-serif;font-weight:bold; text-shadow: 0.25px 0.25px gray;">Edit Configuration ' . $_GET['file'] . '</h1>';?>

<?php
$password = "www-data";
$command = "echo '$password' | sudo -S chmod -R 777 /etc/svxlink/";
exec($command);
exec('sudo chown -R www-data:www-data /etc/svxlink/');
exec('sudo chown -R www-data:www:data /var/www/html');

?>

<?php

$node_InfoFile=$_GET['file'];
exec('sudo cp ' . $node_InfoFile . ' ' .$node_InfoFile .'.bak');
include_once('include/functions.php');
$lines = file($node_InfoFile);

//echo '<form method="post" enctype="multipart/form-data" action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '">';
//echo '<table width=60%>';
//echo "Here Now with " . $node_InfoFile;
if (fopen($node_InfoFile,'r'))
  {
  $filedata = file_get_contents($node_InfoFile);
  //print_r($filedata);
  $node_Info = json_decode($filedata,true);
  //print_r($node_Info);
  build_ini_string(array($node_Info));
  //print_r($sectionless . $out);
  };
if (isset($_POST['btnSave']))
    {
        $retval = null;
        $screen = null;
	
    $node_Info["Location"] = $_POST['inLocation']; 
    $node_Info["Locator"] = $_POST['inLocator'];
    $node_Info["SysOp"] = $_POST['inSysOp'];
	  $node_Info["LAT"] = $_POST['inLAT']; 
    $node_Info["LONG"] = $_POST['inLONG'];
    $node_Info["RXFREQ"] = $_POST['inRXFREQ'];
	  $node_Info["TXFREQ"] = $_POST['inTXFREQ']; 
    $node_Info["Website"] = $_POST['inWebsite'];
    $node_Info["Mode"] = $_POST['inMode'];
	  $node_Info["Type"] = $_POST['inType']; 
    $node_Info["Echolink"] = $_POST['inEcholink'];
    $node_Info["nodeLocation"] = $_POST['innodeLocation'];
	  $node_Info["Compound"] = $_POST['inCompound'];
    $node_Info["CTCSS"] = $_POST['inCTCSS'];
	  $node_Info["LinkedTo"] = $_POST['inLinkedTo'];

	  $jsonnode_Info = json_encode($node_Info);
	  file_put_contents("/var/www/html/node_Info/node_info.json", $jsonnode_Info ,FILE_USE_INCLUDE_PATH);

        $retval = null;
        $screen = null;
        exec('sudo cp /etc/svxlink/node_info.json /etc/svxlink/node_info.json.' .date("YmdThis"), $screen, $retval);
        exec('sudo mv /var/www/html/node_Info/node_info.json /etc/svxlink/node_info.json', $screen, $retval);
        exec('sudo service svxlink restart 2>&1',$screen,$retval);
    };
    $svxconfig = parse_ini_file($svxConfigFile,true,INI_SCANNER_RAW);
    $inCallsign = $svxconfig['ReflectorLogic']['CALLSIGN'];
    $inPassword = $svxconfig['ReflectorLogic']['AUTH_KEY'];
	  $inLocation = $node_Info["nodeLocation"];
    $inLocator = $node_Info["loc"]; 
    $inSysOp = $node_Info["sysop"];
	  $inLAT = $node_Info["lat"];
    $inLONG = $node_Info["long"]; 
    $inRXFREQ = $node_Info["freq"];
	  $inTXFREQ = $node_Info["TXFREQ"];
    $inWebsite = $node_Info["Website"]; 
    $inMode = $node_Info["Mode"];
	  $inType = $node_Info["Type"];
    $inEcholink = $node_Info["Echolink"]; 
    $innodeLocation = $node_Info["nodeLocation"];
	  $inSysop = $node_Info["Sysop"]; 
    $inCTCSS = $node_Info["CTCSS"];
	  $inLinkedTo = $node_Info["LinkedTo"];
    
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table>
        <tr>
        <th width = "640px">Node Info Input</th>
	<th width = "625px">Action</th>
        </tr>
<tr>
<TD>

<Table style="border-collapse: collapse; border: none;">
        <tr style="border: none;">
                <th width = "30%"></th>
                <th width = "70%"></th>
        </tr>
        <tr style="border: none;"> 
        <td style="border: none;">Location
        </td>
        <td style="border: none;">
        <input type="text" name="inLocation" style="width:98%" value="<?php echo $inLocation;?>">
        </td></tr>
        <tr style="border: none;"> 
        <td style="border: none;">Locator</td>
        <td style="border: none;">
        <input  type="text" name="inLocator" style="width:98%" value="<?php echo $inLocator;?>">
        </td></tr>
        <tr style="border: none;"> 
        <td style="border: none;">SysOp</td>
        <td style="border: none;">
        <input  type="text" name="inSysOp" style="width:98%" value="<?php echo $inSysOp;?>">
        </td></tr>
        <tr style="border: none;"> 
        <td style="border: none;">Lat</td>
        <td style="border: none;">
        <input  type="text" name="inLAT" style="width:98%" value="<?php echo $inLAT;?>">
        </td></tr>
        <tr style="border: none;"> 
        <td style="border: none;">Long</td>
        <td style="border: none;">
        <input  type="text" name="inLONG" style="width:98%" value="<?php echo $inLONG;?>">
        </td></tr>
        <tr style="border: none;"> 
        <td style="border: none;">Rx Freq</td>
        <td style="border: none;">
        <input  type="text" name="inRXFREQ" style="width:98%" value="<?php echo $inRXFREQ;?>">
        </td></tr>
        <tr style="border: none;"> 
        <td style="border: none;">Tx Freq</td>
        <td style="border: none;">
        <input  type="text" name="inTXFREQ" style="width:98%" value="<?php echo $inTXFREQ;?>">
        </td></tr>
        <tr style="border: none;"> 
        <td style="border: none;">Website</td>
        <td style="border: none;">
        <input  type="text" name="inWebsite" style="width:98%" value="<?php echo $inWebsite;?>">
        </td></tr>
        <tr style="border: none;"> 
        <td style="border: none;">Mode</td>
        <td style="border: none;">
        <input  type="text" name="inMode" style="width:98%" value="<?php echo $inMode;?>">
        </td></tr>
        <tr style="border: none;"> 
        <td style="border: none;">Type</td>
        <td style="border: none;">
        <input  type="text" name="inType" style="width:98%" value="<?php echo $inType;?>">
        </td></tr>
        <tr style="border: none;"> 
        <td style="border: none;">EchoLink</td>
        <td style="border: none;">
        <input  type="text" name="inEcholink" style="width:98%" value="<?php echo $inEcholink;?>">
        </td></tr>
        <tr style="border: none;"> 
        <td style="border: none;">Node Location</td>
        <td style="border: none;">
        <input  type="text" name="innodeLocation" style="width:98%" value="<?php echo $innodeLocation;?>">
        </td></tr>
        <tr style="border: none;"> 
        <td style="border: none;">Sysop</td>
        <td style="border: none;">
        <input  type="text" name="inSysop" style="width:98%" value="<?php echo $inSysop;?>">
        </td></tr>
        <tr style="border: none;"> 
        <td style="border: none;">Compound</td>
        <td style="border: none;">
        <input  type="text" name="inCompound" style="width:98%" value="<?php echo $inCompound;?>">
        </td></tr>
        <tr style="border: none;"> 
        <td style="border: none;">LinkedTo</td>
        <td style="border: none;">
        <input  type="text" name="inLinkedTo" style="width:98%" value="<?php echo $inLinkedTo;?>">
        </td></tr>
        <tr style="border: none;"> 
        <td style="border: none;">CTCSS</td>
        <td style="border: none;">
        <input  type="text" name="inCTCSS" style="width:98%" value="<?php echo $inCTCSS;?>">
        </td></tr>
    </table>
</td>
<td> 
	<button name="btnSave" type="submit" class="red" style="height:100px; width:105px; font-size:12px;">Save <BR><Br> & <BR><BR> ReLoad</button>
</td>
</tr>
</table>


</form>
<p style="margin: 0 auto;"></p>
<p style="margin-bottom:-2px;"></p>
<!--
foreach ($lines as $line_num => $line) {
    echo '<tr><td contenteditable="true" style="text-align:left"><input type="text" style="width:100%" name="line[]" value="' . htmlspecialchars($line) . '"></td></tr>';
}
echo '</table>';
echo '<input type="submit" value="Click to Save Changes">';
echo '</form>';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = '';
    foreach ($_POST['line'] as $line) {
        $data .= $line . "\n";
    }
    
    $success = file_put_contents($file, $data);
    echo $file . "  " . $data;
    if ($success === false) {
        echo 'Error saving changes to file.';
    } else {
        chown ($file,'www-data');
        exec('sudo systemctl restart svxlink');
        echo 'Changes saved and service restarted.';
    }   
        //exec('sudo chown -R www-data:root /etc/svxlink/');
}
//echo "<meta http-equiv='refresh' content='0'>";
exit();
//Header('Location: ' . htmlspecialchars($_SERVER['PHP_SELF']));
//exit(); 
-->
</fieldset>
</body>
</html>