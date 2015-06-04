<?php

function logStr($str)
{
	$folder = getcwd ( );//current directory
	$file = $folder . '\index.log.txt';
	file_put_contents($file, $str . PHP_EOL, FILE_APPEND);
}

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
  include 'addjoke.html.php';
  exit();
}

/* _this one seems to throw an error we can't detect */
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
	logStr('id = ' . $sql);
	/* header('Location: .');  
	exit(); */
	if (!mysqli_query($link, $sql))
	{
		showError('Error deleting submitted joke: ' . mysqli_error($link));
	}
	header('Location: .');  
	exit();  
}

if (isset($_POST['joketext']))
{
	/* to add a joke, first we need to look up the author (flexibly)*/
	$author = mysqli_real_escape_string($link, $_POST['author']);
	$author = trim($author);
	/* we're still not considering upper/lower case correctly;
	this would suppedly work COLLATE utf8_general_ci */
	$sql = 'SELECT id, name FROM author WHERE name LIKE "' . $author . '"';
	$result = (mysqli_query($link, $sql));
	if ($result)
	{
		/* it seems we get *something* back 
		   regardless of a match with LIKE */
		$row = mysqli_fetch_array($result);
		$id = $row['id'];
		if ($id == 0)
		{
			$email = mysqli_real_escape_string($link, $_POST['email']);
			$sql = 'INSERT INTO author SET ' .
				'name = "' . $author . '"' .
				', email = "' . $email . '"';
			/* printf($sql); */
			if (mysqli_query($link, $sql))
			{
				$sql = 'SELECT LAST_INSERT_ID()';
				$result = (mysqli_query($link, $sql));
				$row = mysqli_fetch_array($result);
				$id = $row[0];
			} else
			{
				showError('Error adding author: ' . mysqli_error($link));
			}
		}
	}
	
	$joketext = mysqli_real_escape_string($link, $_POST['joketext']);
	$sql = 'INSERT INTO joke SET ' .
      'joketext = "' . $joketext . '"' .
	  ', authorid = "' . $id . '"'.
      ', jokedate=CURDATE()';
	  
	if (!mysqli_query($link, $sql))
	{
		showError('Error adding joke: ' . mysqli_error($link));
	}
	header('Location: .'); /* the "." means the us, given our name */
	exit();
}

/* what do we need jokedate and email for? */
$sql= 'SELECT joke.id, joketext, jokedate, name, email '
	. 'FROM joke INNER JOIN author ON authorid = author.id';
/* logStr($sql); */
$result = mysqli_query($link, $sql);
if ($result)
{
	/* build an array of jokes with name/value pairs,
	 jokeid1 = joketext1
	 jokeid2 = joketext2
	 : */
	while ($row = mysqli_fetch_array($result))
	{
		$jokes[] = array('id' => $row['id'], 'text' => $row['joketext'], 
			'name' => $row['name'], 'email' => $row['email']);
	}
	include 'jokes.html.php';
} else
{
	showError('Error fetching jokes: ' . mysqli_error($link));
}

?>



