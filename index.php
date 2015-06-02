<?php

function showError($str)
{
	$error = $str . "; exiting";
	include 'error.html.php';
	exit();
}

/* this one seems to throw an error we don't detect
   we could probably add a try/catch mechanism... */
$link = mysqli_connect("localhost", "joke-user", "joke-pass");
if (!$link)
{
	showError('Unable to connect to database');
}

if (!mysqli_set_charset($link, 'utf8'))
{
	showError('Unable to set charset');
}

if (!mysqli_select_db($link, 'ijdb'))
{
	showError('Unable to select records');
}

if (false)
{
	$sql = 'CREATE TABLE joke2 (  
		  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,  
		  joketext TEXT,  
		  jokedate DATE NOT NULL  
		) DEFAULT CHARACTER SET utf8';  
	if (!mysqli_query($link, $sql))  
	{  
	  $error = 'Error creating joke table: ' . mysqli_error($link);  
	  include 'error.html.php';  
	  exit();  
	}
	
	$output = 'Another Joke table successfully created.';  
	include 'output.html.php';
}  

if (false)
{
	$sql = 'UPDATE joke SET jokedate="2011-07-11"  
			WHERE joketext NOT LIKE "%chicken%"';  
	if (mysqli_query($link, $sql))  
	{
		$rows = 'Updated ' . mysqli_affected_rows($link) . ' rows.';  
	} else
	{  
	  $error = 'Error performing update: ' . mysqli_error($link);  
	  include 'error.html.php';  
	  exit();  
	}
}

$result = mysqli_query($link, 'SELECT joketext FROM joke');  
if ($result)  
{
	/* build an output string with line breaks: */
	$jokes = '';
	while ($row = mysqli_fetch_array($result))  
	{  
	  $jokes = $jokes . $row['joketext'] . '<br>';  
	}  
	include 'jokes.html.php';  
} else 
{  
  $error = 'Error fetching jokes: ' . mysqli_error($link);  
  include 'error.html.php';  
  exit();  
}

?>




