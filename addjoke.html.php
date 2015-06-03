<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Add Joke</title>
    <style type="text/css">
      textarea {
		 display: block;
        width: 100%;
      }
    </style>
  </head>
  <body>
    <form action="?" method="post">
      <div>
        <label for="joketext">Type your joke here:</label>
        <textarea id="joketext" name="joketext" rows="3" cols="40"></textarea>
      </div>
	  <div>
        <label for="author">Name:</label>
        <input id="author" name="author"></input>
		<label for="email">Email:</label>
		<input id="email" name="email"></input>
      </div>
      <div><input type="submit" value="Add"></div>
    </form>
  </body>
</html>