<?php
//session_start() creates a session or resumes the current one
ob_start();
include_once 'database.lib.php';

if (!isset($_SESSION))
{
	session_start();
	
	if (isset($_REQUEST["ckLog"]))
	{
		
		db_connect();
		
		$user = $_REQUEST["ckLogU"];
		$pwd = $_REQUEST["ckLogP"];
	
		$select = "SELECT * FROM utenti WHERE username = '".mysql_real_escape_string($user)."' AND password = '".md5($pwd)."' LIMIT 1;";
		$result = qdb ( $select );
	
		if (row($result)>0)
		{
			$_SESSION["idutente"] = result($result,0,"id");
			$_SESSION["logged"] = date("Y-m-d H:i:s");
			
			print '{"result":"ok"}';
	
		}
		else
		{
			print '{"result":"error"}';
			exit;
		}
	}
	else
	{
		echo "<a href=\"index.php\">Sessione scaduta: effettua un nuovo login!</a>";
		exit;
	}
}
else
{
	$_SESSION['script_url'] = $_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"];
	db_connect();
}
?>