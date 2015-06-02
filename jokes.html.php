<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>List of Jokes</title>  
		<style>
			.left
			{
				margin-left: 0.5cm;
			}
			.copydate
			{
				font-size: 0.5em;
				font-style: italic;
			}
		</style>
	</head>  
	<body>  
		<p><a href="?addjoke">Add your own joke</a></p>  
		<p>Here are all the jokes in the database:</p>
		<p class="left"><?php echo $jokes; ?></p>
	</body>  
	<footer>
		<p class="copydate">
			Copyright © 2015 Al Heithaus.<br>
			All Rights Reserved.<br>
			File Date 2 June 2015.
		</p>
	</footer>

</html>
