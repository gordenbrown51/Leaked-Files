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
	
	$result_owns = mysql_query( "SELECT COUNT(id) AS thecount FROM server_backup WHERE srvid = '{$serverid}' and status = 'copying' or status = 'restore'"  );
	while ( $row_owns = mysql_fetch_array( $result_owns ) )
    {
        $user_owns2 = $row_owns['thecount'];
    }
	if (is_numeric($user_owns2) && $user_owns2 >= 1) {
        $_SESSION['msg'] = "Backup is in process please wait!";
        header("Location: gp-backup2.php?id=" . $serverid);
        exit();
    }
        
    if ($data){
		
		if (is_numeric($data)){
			
			$name = query_fetch_assoc("SELECT * FROM `server_backup` WHERE `id` = '{$data}'");
			$name = explode(".", $name['name']);
			
        }
		else die();
    }
	
	$name1 = $name[0].".".$name[1];
	
	$cmd = "
	    
		if [ -f /home/backupnew/$name1.tar.gz ]; then
		   rm -f /home/backupnew/$name1.tar.gz;
		   if [ $? -ne 0 ]; then
		       echo \"error\";exit
		   fi;
		fi;
		
		if [ -d /home/backupnew/$name1.pack ]; then
		   rm -R /home/backupnew/$name1.pack;
		   if [ $? -ne 0 ]; then
		       echo \"error\";exit
		   fi;
		fi;
		
		echo \"success\";exit
		
        ";
	

		
	$ssh_return = ssh_exec( "5.230.134.155", 22, "backupnew", "backupnew", $cmd ,true);
    
	if ( $ssh_return  == "success" ){
	
	   mysql_query("DELETE FROM `server_backup` WHERE `id` = '".$data."'");
	   
	   $_SESSION['msg'] = "Backup successfully deleted!";
	   header("Location: gp-backup.php?id=" . $serverid);
	   die();
	}
	$_SESSION['msg'] = "Backup successfully deleteddas!";
	header("Location: gp-backup.php?id=" . $serverid);
	die();
			
?>