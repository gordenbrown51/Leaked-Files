<?php
include("configs.php");
$cg2 = new CSRFGuard($task);
    if( !($cg2->checkToken( $task, "bfe7507954135d" )) ) {
        
        //$_SESSION['msg'] = "Invalit token please try again..";
        //header("Location: gp-backup.php?id=" . $serverid);
    }
    
    $serverid = mysql_real_escape_string($_POST['serverid']);
    if (empty($serverid)) $error = "SERVER ID mora biti unet!";
    if (!is_numeric($serverid)) $error = "Greska";
    
    
    $data = mysql_real_escape_string($_POST['data']);
	
	
	
	if ($data){
		
		if (is_numeric($data)){
			
			$name = query_fetch_assoc("SELECT * FROM `server_backup` WHERE `id` = '{$data}'");
			$tarname = $name['name'];
			$name = explode(".", $tarname);
			
			
        }
		else die();
    }
	
	$klijent = query_fetch_assoc("SELECT * FROM `klijenti` WHERE `klijentid` = '" . $_SESSION['klijentid'] . "'");

	
	$query = "SELECT
    s.id,
    s.box_id,
    s.username,
    s.name,
    s.ip_id,
    s.backupstatus,
	s.password AS passworduser,
	
    b1.boxid,
    b1.sshport,
    b1.login,
    b1.password,
    
    b2.ip
    
    FROM serveri AS s
    LEFT JOIN box AS b1 ON s.box_id = b1.boxid
    LEFT JOIN boxip AS b2 ON s.ip_id = b2.ipid  WHERE `id`='$serverid'";
    
    if (!($result = mysql_query($query))) {
        //exit("Failed!! " . mysql_error());
        $error = "Failed!!";
    }
    $net_arr = array();
    
    $aes = new Crypt_AES();
    $aes->setKeyLength(256);
    $aes->setKey(CRYPT_KEY);
    
    while ($line = mysql_fetch_assoc($result)) {
		
        foreach ($line as $key => $value) {
            if ($key == "password") 
            $net_arr[$key] = $aes->decrypt($value);
            else
            $net_arr[$key] = $value;
        }
		
    }
	
	$result_owns = mysql_query( "SELECT COUNT(id) AS thecount FROM server_backup WHERE srvid = '{$serverid}' and status = 'copying' or status = 'restore'"  );
	while ( $row_owns = mysql_fetch_array( $result_owns ) )
    {
        $user_owns2 = $row_owns['thecount'];
    }
	if (is_numeric($user_owns2) && $user_owns2 >= 2) {
        $_SESSION['msg'] = "Backup is in process please wait!";
        header("Location: gp-backup.php?id=" . $serverid);
        exit();
    }
	
	$srvftpn = $net_arr['username'];
	
	$ip = query_fetch_assoc("SELECT * FROM `boxip` WHERE `ipid` = '".$net_arr['ip_id']."'");
	$box = query_fetch_assoc("SELECT * FROM `box` WHERE `boxid` = '".$net_arr['box_id']."'");
	$boxip = query_fetch_assoc("SELECT * FROM `boxip` WHERE `ipid` = '".$net_arr['ip_id']."'");
	
	$time = time();
	
	stop_serverbackup($ip['ip'], $box['sshport'], $net_arr['username'], $net_arr['passworduser'], $serverid, "admin", TRUE);
	
	//mysql_query("UPDATE `serveri` SET `backupstatus` = 'copying' WHERE `id` = '".$serverid."'");
	
	$name1 = $net_arr['name'];
	

	
	$cmd = "
	
	dpkg -l | grep -qw sshpass || apt-get -y install sshpass;dpkg -l | grep -qw ssh || apt-get -y install ssh;dpkg -l | grep -qw rsync || apt-get -y install rsync;
	
	rm -r /home/backupnew/tmp/unpack/{$net_arr['username']}.unpack;
	if [[ ! -e /home/backupnew/tmp/unpack/{$net_arr['username']}.unpack ]]; then
            mkdir -p /home/backupnew/tmp/unpack/{$net_arr['username']}.unpack;
	fi;
	
	nice -n 19 tar -zxf /home/backupnew/$tarname -C /home/backupnew/tmp/unpack/{$net_arr['username']}.unpack;
	if [ $? -ne 0 ]; then
	    wget -qO- \"http://morenja.info/admin/cronovi/backup-api.php?task=restore&serverid={$serverid}&name={$srvftpn}.$time.tar.gz&status=errortmpuntar\";exit;
    fi;
	
	sshpass -p \"{$net_arr['passworduser']}\" ssh -p {$box['sshport']} -o StrictHostKeyChecking=no {$net_arr['username']}@{$ip['ip']} '

	
	rm -r /home/{$net_arr['username']}/*;
	
	rsync --bwlimit=8000 -e \"sshpass -p 'backupnew' ssh -p 22 -o StrictHostKeyChecking=no\" -a backupnew@5.230.134.155:/home/backupnew/tmp/unpack/{$net_arr['username']}.unpack/* /home/{$net_arr['username']}/;
	if [ $? -ne 0 ]; then
	    wget -qO- \"http://morenja.info/admin/cronovi/backup-api.php?task=restore&serverid={$serverid}&name={$srvftpn}.$time.tar.gz&status=errortmpunrsync\";exit;
    fi;
	
	chown -R {$net_arr['username']}:{$net_arr['username']} /home/{$net_arr['username']};
	
	wget -qO- \"http://morenja.info/admin/cronovi/backup-api.php?task=restore&serverid={$serverid}&name={$tarname}&status=ok\";exit;
	
	'
	rm -r /home/backupnew/tmp/unpack/{$net_arr['username']}.unpack;
	
	";


	
	
	if (!($ssh_return = ssh_exec( "5.230.134.155", 22, "backupnew", "backupnew", $cmd, false, false))) {
            $error = $jezik['text292'];
    } 
	else {
		
		mysql_query("UPDATE `server_backup` SET `status` = 'restore' WHERE `id` = '".$data."'");
		
        $_SESSION['msg'] = "Backup successfully restored!";
		header("Location: gp-backup.php?id=" . $serverid);
		die();
    }
		
	exit();


function stop_serverbackup($ip, $port, $username, $password, $serverid, $klijentid, $restart)
{
	if($klijentid == "admin") 
		$server = query_fetch_assoc("SELECT * FROM `serveri` WHERE `id` = '".$serverid."'");
	else 
		$server = query_fetch_assoc("SELECT * FROM `serveri` WHERE `id` = '".$serverid."' AND `user_id` = '".$_SESSION['klijentid']."'");

	if(query_numrows("SELECT * FROM `serveri` WHERE `id` = '".$serverid."' AND `user_id` = '".$_SESSION['klijentid']."'") == 0)
		{
			return $jezik['text289'];
		}
	if($restart == FALSE)
	{
		if($server['startovan'] == "0")
		{
			return $jezik['text295'];
		}
	}
	if($server['status'] == "Suspendovan")
		{
			return $jezik['text294'];
		}
	if (!function_exists("ssh2_connect")) return $jezik['text290'];
    
	$serverport = $server['port'];
	
	if ($server['mod'] == "51")
		$cmd = "kill -9 `screen -list | grep \"$username\" | awk {'print $1'} | cut -d . -f1`; kill -9 $(netstat -ntlp |grep -P \"$ip:$serverport\" |awk '{print $7}' |cut -d / -f 1);";
	else
		$cmd = "kill -9 `screen -list | grep \"$username\" | awk {'print $1'} | cut -d . -f1`; kill -9 $(netstat -ntlp |grep -P \"$ip:$serverport\" |awk '{print $7}' |cut -d / -f 1);";
	

	if ( !( $ssh_return = ssh_exec( $ip, $port, $username, $password, $cmd ,true) ) )
	{
		return false;

	}
	query_basic("UPDATE `serveri` SET `startovan` = '0' WHERE `id` = '".$serverid."'");	
	
	return 'stopiran';
	
	if(!($con = ssh2_connect($ip, $port))) return $jezik['text292'];
	else 
	{
		if(!ssh2_auth_password($con, $username, $password)) return $jezik['text293'];
		else 
		{
			$stream = ssh2_shell($con, 'vt102', null, 80, 24, SSH2_TERM_UNIT_CHARS);
			//fwrite( $stream, 'kill -9 `screen -list | grep "'.$username.'" | awk {\'print $1\'} | cut -d . -f1`'.PHP_EOL);
			//fwrite( $stream, 'pkill -u "'.$username.'"'.PHP_EOL);
			
			$line_stop = "kill -9 `screen -list | grep \"$username\" | awk {'print $1'} | cut -d . -f1`";
			fwrite( $stream, $line_stop);
			
			
			sleep(1);
			fwrite( $stream, 'screen -wipe'.PHP_EOL);
			sleep(1);
			
			$data = "";
			
			while($line = fgets($stream)) 
			{
				$data .= $line;
			}
			query_basic("UPDATE `serveri` SET `startovan` = '0' WHERE `id` = '".$serverid."'");			
			return 'stopiran';
		}
	}	
}
			
?>