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
			.button
			{
				float: left;
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
		<?php foreach ($jokes as $joke): ?>
			<form action="?deletejoke" method="post">
			<blockquote>
				<p>
					<?php echo $joke['text'] . ', by ' . $joke['name']; ?>
					<input type="hidden" name="id" value="<?php echo $joke['joke.id']; ?>">
					<input type="submit" value="Delete">
					<input type="submit" value="Edit">
				</p>
			</blockquote>
		<?php endforeach; ?>
	</body>  
	<footer>
		<p class="copydate">
			Copyright © 2015 Al Heithaus.<br>
			All Rights Reserved.<br>
			File Date 2 June 2015.
		</p>
	</footer>

</html>
