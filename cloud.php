<?php
require 'config.php';

// In the SQL below, change these three things:
// thing is the column name that you are making a tag cloud for
// id is the primary key
// my_table is the name of the database table

$query = "SELECT word AS tag, COUNT(id) AS quantity
  FROM words
  GROUP BY word ORDER BY id";

$result = mysql_query($query);

// here we loop through the results and put them into a simple array:
// $tag['thing1'] = 12;
// $tag['thing2'] = 25;
// etc. so we can use all the nifty array functions
// to calculate the font-size of each tag
while ($row = mysql_fetch_array($result)) {
    $tags[$row['tag']] = $row['quantity'];
}

// change these font sizes if you will
$max_size = 2.5; // max font size in %
$min_size = 1; // min font size in %

// get the largest and smallest array values
$max_qty = max(array_values($tags));
$min_qty = min(array_values($tags));

// find the range of values
$spread = $max_qty - $min_qty;
if (0 == $spread) { // we don't want to divide by zero
    $spread = 1;
}

// determine the font-size increment
// this is the increase per tag quantity (times used)
$step = ($max_size - $min_size)/($spread);

$html = '';
// loop through our tag array
foreach ($tags as $key => $value) {

    // calculate CSS font-size
    // find the $value in excess of $min_qty
    // multiply by the font-size increment ($size)
    // and add the $min_size set above
    $size = $min_size + (($value - $min_qty) * $step);
    // uncomment if you want sizes in whole %:
    // $size = ceil($size);

    // you'll need to put the link destination in place of the #
    // (assuming your tag links to some sort of details page)
    $html .= '<span style="font-size: '.$size.'em; text-decoration: underline;" title="'.$value.'">'.strtolower($key).'</span> '."\n";
    // notice the space at the end of the link
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
  <?= $html ?>
  </div>
  <div id="ft">
    &copy; 2009 <a href="http://jeremyhubert.com">Jeremy Hubert</a>, although I'd probably let you use it if you just ask me.
  </div>
</body>
</html>
<?
if ($_GET['debug']) {
  $query = "SELECT * FROM words ORDER BY id;";

  $result = mysql_query($query);
  echo "<!--";
  while ($row = mysql_fetch_array($result)) {
    echo $row['word'] . ', ' . $row['ip'] . ', ' . $row['name'] . "\n";
  }
  echo "//-->";
}
?>