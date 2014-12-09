<?php 

include_once 'setup.inc';

function db_connect($ch=0)
{
	global $connessione;
	global $ip_db_inc;
	global $user_db_inc;
	global $pwd_db_inc;
	global $name_db_inc;

	//	print $ip_db_inc."<br />";
	//	print $user_db_inc."<br />";
	//	print $pwd_db_inc."<br />";
	//	print $name_db_inc."<br />";

	$connessione=@mysql_connect($ip_db_inc, $user_db_inc,$pwd_db_inc);

	//workaraund per salvare caratteri UTF-8 in DB
	//�� preferibile utilizzare mysql_set_charset (PHP 5 >= 5.2.3)
	qdb("SET NAMES 'utf8'");
	//----------------------

	if (!$connessione)
	{
		if (isset($_SERVER["REMOTE_ADDR"]))
		{
			$remoteaddress=$_SERVER["REMOTE_ADDR"];
			$remotehost=@gethostbyaddr($remoteaddress);
		}
		else
		{
			$remoteaddress="Unknown";
			$remotehost="Unknown";
		}

		if (isset($_SERVER["PHP_SELF"]) and !empty($_SERVER["PHP_SELF"]))
			$namescript=$_SERVER["PHP_SELF"];
		elseif (isset($_SERVER["argv"][0]))
			$namescript=$_SERVER["argv"][0];
		else
			$namescript="";

		$string_error="Error ".date("Y-m-d H:i:s").": DB connection error ($remoteaddress\t$remotehost):\n". mysql_error()."\nScript: $namescript";
		error_handling(3,"$string_error");

		if (empty($ch))
		{
			print "DB connection failed.";
			exit;
		}
		else
		{
			return false;
		}
	}
	else
	{
		if (empty($db))
			$db=$name_db_inc;

		$use_database = mysql_select_db("$db");
		if (!$use_database)
		{
			if (empty($ch))
			{
				print "DB selected failed.";
				exit;
			}
			else
			{
				return false;
			}
		}
		else
			return true;
	}
}

function qdb($queryString,$ch="SOAP")
{
	global $connessione;
	$queryResult = mysql_query($queryString,$connessione);

	if (!$queryResult)
	{
		if (isset($_SERVER["REMOTE_ADDR"]))
		{
			$remoteaddress=$_SERVER["REMOTE_ADDR"];
			$remotehost=@gethostbyaddr($remoteaddress);
		}
		else
		{
			$remoteaddress="Unknown";
			$remotehost="Unknown";
		}
		if (isset($_SERVER["PHP_SELF"]) and !empty($_SERVER["PHP_SELF"]))
			$namescript=$_SERVER["PHP_SELF"];
		elseif (isset($_SERVER["argv"][0]))
		$namescript=$_SERVER["argv"][0];
		else
			$namescript="";

		$string_error="Error ".date("Y-m-d H:i:s")." : DB connection error ($remoteaddress\t$remotehost)\nScript: $namescript\n$queryString\nError:\n".mysql_errno($connessione) . ": " . mysql_error($connessione)."\n";
		error_handling(1,"$string_error");

		if (empty($ch))
		{

			print "DB query error.\n";
			if (isset($_SERVER["SERVER_NAME"]) && ($_SERVER["SERVER_NAME"]=="localhost" or $_SERVER["SERVER_NAME"]='127.0.0.1'))
				print "$string_error\n";
			exit;
		}
		elseif ($ch == 1)
		{
			return false;
		}
		elseif ($ch == "SOAP")
		{
			$ret_data["result"]=array(
					'errno'=>mysql_errno($connessione),
					'error'=>mysql_error($connessione),
					'script'=> $namescript,
					'query'=> $queryString
			);
			return $ret_data;
		}
		else
			return("ER");
	}
	return $queryResult;
}

function result($val,$prog,$col)
{
	$result = mysql_result($val,$prog,$col);
	return $result;
}

function row($var)
{
	$rows = mysql_num_rows($var);
	return $rows;
}

function error_handling($level,$stringa_error)
{
	$datetemp=date("Y-m-d H.i.s");
	print $datetemp." : ".$stringa_error;
}

?>