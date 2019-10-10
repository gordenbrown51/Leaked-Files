
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
	
	$klijent = query_fetch_assoc("SELECT * FROM `klijenti` WHERE `klijentid` = '" . $_SESSION['klijentid'] . "'");
	
	$query = "SELECT
    s.id,
    s.box_id,
    s.username,
    s.name,
    s.ip_id,
    s.backupstatus,
	
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
	
	$result_owns = mysql_query( "SELECT COUNT(id) AS thecount FROM server_backup WHERE srvid = '{$serverid}'" );
	while ( $row_owns = mysql_fetch_array( $result_owns ) )
    {
        $user_owns = $row_owns['thecount'];
    }
	
	//$listdata = get_backup_data2($_SESSION['klijentid'],$serverid,true);
	if (is_numeric($user_owns) && $user_owns >= _MAX_USERBACKUPS) {
        $_SESSION['msg'] = "Limit of "._MAX_USERBACKUPS." backup's reached please delete one!";
        header("Location: gp-backup.php?id=" . $serverid);
        exit();
    }
	
	$result_owns = mysql_query( "SELECT COUNT(id) AS thecount FROM server_backup WHERE srvid = '{$serverid}' AND status = 'copying' OR status = 'restore'"  );
	while ( $row_owns = mysql_fetch_array( $result_owns ) )
    {
        $user_owns2 = $row_owns['thecount'];
    }
	if (is_numeric($user_owns2) && $user_owns2 >= 2) {
        $_SESSION['msg'] = "Backup is in process please wait!";
        header("Location: gp-backup.php?id=" . $serverid);
        exit();
    }
	
	
	//screen -dmS '{$srvftpn}_backup' sh -c \"sleep 10;rsync --bwlimit=8000 -e 'sshpass -p \"PdetxzseeNbZ\" ssh -p 22 -o StrictHostKeyChecking=no' -a /home/{$srvftpn} root@46.105.111.181:/home/backupnew/;
	$srvftpn = $net_arr['username'];
	
	
	$time = time();
	
	//mysql_query("UPDATE `serveri` SET `backupstatus` = 'copying' WHERE `id` = '".$serverid."'");
	
	$cmd = "
	dpkg -l | grep -qw sshpass || apt-get -y install sshpass;
	dpkg -l | grep -qw ssh || apt-get -y install ssh;
	dpkg -l | grep -qw rsync || apt-get -y install rsync;
	
	if [[ ! -e /home/backupnew ]]; then
            mkdir -p /home/backupnew;
	fi;
	cd /home/backupnew;
	
	rsync --bwlimit=50000 -e 'sshpass -p \"backupnew\" ssh -p 22 -o StrictHostKeyChecking=no' -a /home/{$srvftpn}/* backupnew@5.230.134.155:/home/backupnew/{$srvftpn}.$time.pack;
	
	if [ $? -ne 0 ]; then
	    wget -qO- \"http://morenja.info/admin/cronovi/backup-api.php?task=backupapi&serverid={$serverid}&name={$srvftpn}.$time.tar.gz&status=error1\";exit;
    fi;
	
	sshpass -p \"backupnew\" ssh -p 22 -o StrictHostKeyChecking=no backupnew@5.230.134.155 '
	
	if [[ ! -e /home/backupnew/tmp ]]; then
            mkdir -p /home/backupnew/tmp;
	fi;
	
	cd /home/backupnew/{$srvftpn}.$time.pack;
	if [ $? -ne 0 ]; then
	    wget -qO- \"http://morenja.info/admin/cronovi/backup-api.php?task=backupapi&serverid={$serverid}&name={$srvftpn}.$time.tar.gz&status=error2\";exit;
	fi;
	nice -n 19 tar -czf /home/backupnew/tmp/{$srvftpn}.$time.tar.gz *;
	if [ $? -ne 0 ]; then
	    wget -qO- \"http://morenja.info/admin/cronovi/backup-api.php?task=backupapi&serverid={$serverid}&name={$srvftpn}.$time.tar.gz&status=error3\";exit;
	fi;
	
	rm -r /home/backupnew/{$srvftpn}.$time.pack;
	mv /home/backupnew/tmp/{$srvftpn}.$time.tar.gz /home/backupnew/{$srvftpn}.$time.tar.gz;
	
	getsize=$(du -b /home/backupnew/{$srvftpn}.$time.tar.gz | cut -f1);
	
	wget -qO- \"http://morenja.info/admin/cronovi/backup-api.php?task=backupapi&serverid={$serverid}&size=\$getsize&name={$srvftpn}.$time.tar.gz&status=ok\";exit;
	
	'
	
	";


	
	if (!($ssh_return = ssh_exec($net_arr['ip'], $net_arr['sshport'], $net_arr['login'], $net_arr['password'], $cmd, false, false))) {
            $error = $jezik['text292'];
    } 
	else {
		
		    $backupname = "$srvftpn.$time.tar.gz";
			$backupstatus = "copying";
			
			mysql_query("INSERT INTO `server_backup` (srvid, name, time, status) VALUES('".$serverid."', '".$backupname."', '".$time."', '".$backupstatus."')");
			$_SESSION['msg'] = "Backup successfully created!";
            header("Location: gp-backup.php?id=" . $serverid);
            die();
        }
		
	exit();


			
?>