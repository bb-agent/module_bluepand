<? 
/*
    Copyright (C) 2013-2015 xtr4nge [_AT_] gmail.com
	Module BluePand created by @AnguisCaptor

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/ 
?>
<?

include "../../../config/config.php";
include "../_info_.php";
include "../../../login_check.php";
include "../../../functions.php";

include "options_config.php";

// Checking POST & GET variables...
if ($regex == 1) {
    regex_standard($_GET["service"], "../msg.php", $regex_extra);
    regex_standard($_GET["action"], "../msg.php", $regex_extra);
    regex_standard($_GET["page"], "../msg.php", $regex_extra);
    regex_standard($io_action, "../msg.php", $regex_extra);
    regex_standard($_GET["install"], "../msg.php", $regex_extra);
}

$service = $_GET['service'];
$action = $_GET['action'];
$page = $_GET['page'];
$install = $_GET['install'];

if($service != "") {
    
    if ($action == "start") {
		$exec = "sudo $bin_pand -c ".$bluepand_mac." --role PANU --persist 1";
		exec_blackbulb($exec);
        
    } else if($action == "stop") {
        // STOP MODULE
        $exec = "$bin_killall $bin_pand_name";
        exec_blackbulb($exec);
    }
    else if($action == "pair") {
        $exec = "$bin_hciconfig hci0 piscan";
        exec_blackbulb($exec);
		
        //$exec = "$bin_bluetooth_agent 1234 > /dev/null 2>&1 &"; //run the agent in the background
		$exec = "$bin_bluetooth_agent $bluepand_keypass > /dev/null 2>&1 &"; //run the agent in the background
        exec_blackbulb($exec);
    }
    else if($action == "stop_pair") {
        $exec = "$bin_killall $bin_bluetooth_agent";
        exec_blackbulb($exec);
		
        $exec = "$bin_hciconfig hci0 noscan";
        exec_blackbulb($exec);
    }

}

if ($install == "install_$mod_name") {

    $exec = "chmod 755 install.sh";
    exec_blackbulb($exec);

    $exec = "$bin_sudo ./install.sh";
    exec_blackbulb($exec);

    header('Location: ../../install.php?module='.$mod_name);
    exit;
}

if ($page == "status") {
    header('Location: ../../../action.php');
} else {
    header('Location: ../../action.php?page='.$mod_name);
}

?>
