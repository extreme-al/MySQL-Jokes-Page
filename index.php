<?php

if (get_magic_quotes_gpc())
{
  function stripslashes_deep($value)
  {
    $value = is_array($value) ?
        array_map('stripslashes_deep', $value) :
        stripslashes($value);
    return $value;
  }
  $_POST = array_map('stripslashes_deep', $_POST);
  $_GET = array_map('stripslashes_deep', $_GET);
  $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
  $_REQUEST = array_map('stripslashes_deep', $_REQUEST);
}

function showError($str)
{
	$error = $str . "; exiting";
	include 'error.html.php';
	exit();
}

if (isset($_GET['addjoke']))
{
  include 'form.html.php';
  exit();
}


/* _this one seems to throw an error we can't detect
   we could probably add a try/catch mechanism... */
try
{
	$link = mysqli_connect('localhost', 'joke-user', 'joke-pass');
	if (!$link)
	{
		showError('Unable to connect to database');
	}
} catch (Exception $ex)
{
	showError('Caught exception:' ,  $e->getMessage());
}

if (!mysqli_set_charset($link, 'utf8'))
{
	showError('Unable to set charset');
}

if (!mysqli_select_db($link, 'ijdb'))
{
	showError('Unable to select records');
}

if (isset($_GET['deletejoke']))
{
	$id = mysqli_real_escape_string($link, $_POST['id']);
	$sql = 'DELETE FROM joke WHERE ID = ' . $id;
	if (!mysqli_query($link, $sql))
	{
		showError('Error adding submitted joke: ' . mysqli_error($link));
	}
	header('Location: .');  
	exit();  
}

if (isset($_POST['joketext']))
{
	/* add a joke */
	$joketext = mysqli_real_escape_string($link, $_POST['joketext']);
	$sql = 'INSERT INTO joke SET
	joketext="' . $joketext . '",
	jokedate=CURDATE()';
	if (!mysqli_query($link, $sql))
	{
	showError('Error adding submitted joke: ' . mysqli_error($link));
	}
	header('Location: .'); /* the "." means the current directory--meaning *us* */
	exit();
}

$result = mysqli_query($link, 'SELECT id, joketext FROM joke');
if ($result)
{
	/* build an array of jokes (so they can be displayed with buttons): */
	while ($row = mysqli_fetch_array($result))
	{
		/* somehow, this adds two elements to the array  */
		$jokes[] = array('id' => $row['id'], 'text' => $row['joketext']); 
	}
	include 'jokes.html.php';
} else
{
	showError('Error fetching jokes: ' . mysqli_error($link));
}

?>




