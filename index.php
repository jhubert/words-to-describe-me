<?php
require 'config.php';

$submitted = false;
if (isset($_POST['word1']) && isset($_POST['word2'])) {
  $name = mysql_real_escape_string($_POST['name']);
  $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
  
  $query = sprintf("INSERT INTO `words` (`word`,`name`,`ip`) VALUES ('%s','%s','%s'),('%s','%s','%s');",
              mysql_real_escape_string($_POST['word1']), $name, $ip,
              mysql_real_escape_string($_POST['word2']), $name, $ip);
  mysql_query($query);
  $submitted = true;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Little Words</title>
  <link rel="stylesheet" href="../style.css" type="text/css" />
  <style type="text/css" media="screen">
    h1, #container, #ft { width: 500px; }
    label { font-size: 1.1em; }
    input { font-size: 2em; }
  </style>
</head>
<body>
  <h1><a href="/playground/">Jeremy Hubert's Playground</a></h1>
  <div id="container">
<?php if($submitted) { ?>
  <h2>Thanks!</h2>
  <p>Wanna <a href="index.php">do it again</a> or <a href="cloud.php">see the results</a>?</p>
  <p>You can use bad words too.<br /> I appreciate the constructive criticism.</p>
  <p>&mdash; Jeremy</p>
<?php } else { ?>
  <h2>I would describe Jeremy as:</h2>
  <form method="post" action="index.php">
    <fieldset>
      <p><label for="word1">First Word:</label><br /> <input type="text" name="word1" /></p>
      <p><label for="word2">Second Word:</label><br /> <input type="text" name="word2" /></p>
      <p><label for="name">Your Name: (totally optional)</label><br /> <input type="text" name="name" /></p>
      <p><input type="submit" value="Say it!" /> or <a href="cloud.php">just see the results</a></p>
    </fieldset>
  </form>
<? } ?>
  </div>
  <div id="ft">
    &copy; 2009 <a href="http://jeremyhubert.com">Jeremy Hubert</a>, although I'd probably let you use it if you just ask me.
  </div>
</body>
</html>