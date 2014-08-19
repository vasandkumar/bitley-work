<?php include('bitly_plugin.php'); 

if(isset($_POST['submit']))
{
	if(isset($_POST['linkurl']))
	{
		$link=$_POST['linkurl'];
		$short = $bitly->shorten($link, $service='bit.ly');
	}
	
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="#" method="post" name="shortnrform">
Enter URL Here:<input type="text" name="linkurl" id="linkurl" />
<input type="submit" name="submit" value="Shrink Url" />


</form>

<?php if(isset($short))
{
	echo $short;
}?>
</body>
</html>