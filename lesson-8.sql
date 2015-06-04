some of the commands we used in the lesson

ALTER TABLE ADD COLUMN authorname VARCHAR(255);
ALTER TABLE ADD COLUMN authoremail VARCHAR(255);

ALTER TABLE joke DROP COLUMN authorname;
ALTER TABLE joke DROP COLUMN authoremail;

CREATE TABLE author (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255)
) DEFAULT CHARACTER SET utf8;

CREATE TABLE joke (  
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,  
  joketext TEXT,  
  jokedate DATE NOT NULL,  
  authorid INT  
) DEFAULT CHARACTER SET utf8;  
CREATE TABLE author (  
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,  
  name VARCHAR(255),  
  email VARCHAR(255)  
) DEFAULT CHARACTER SET utf8;

Lesson 8, Step 4 SELECT with Multiple Tables

INSERT INTO author SET  
  id = 1,  
  name = 'Kevin Yank',  
  email = 'kevin@sitepoint.com';  
INSERT INTO author (id, name, email)  
  VALUES (2, 'Joan Smith', 'joan@example.com');  
INSERT INTO joke SET  
  joketext = 'Why did the chicken cross the road? To get to the other side!',  
  jokedate = '2009-04-01',  
  authorid = 1;  
INSERT INTO joke (joketext, jokedate, authorid)  
  VALUES (  
    'Knock-knock! Who\'s there? Boo! "Boo" who? Don\'t cry; it\'s only a joke!',  
    '2009-04-01',  
    1  
  );  
INSERT INTO joke (joketext, jokedate, authorid)  
  VALUES (  
    'A man walks into a bar. "Ouch."',  
    '2009-04-01',  
    2  
  );
  
  SELECT * FROM
joke INNER JOIN author 
ON authorid = author.id

SELECT joke.id, joketext, jokedate, name, email FROM
joke INNER JOIN author 
ON authorid = author.id