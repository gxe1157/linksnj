<!-- https://www.johnmorrisonline.com/php-try-catch-error-handling/ -->
<pre>
<?php
try {
  echo "Try to do something here.<br />";
  throw new Exception("Yikes. Something went funky.<br />", 234);
} catch (Exception $e) {
  //print_r($e);
  echo $e->getMessage();
} finally {
  echo "This will always run in our try block.<br />";
}
// try {
// 	// connect (create a new MySQLi object)
// 	$mysqli = new MySQLi('localhost', 'root', 'root', 'snippet');
// 	if (mysqli_connect_error())	{
// 		throw new Exception(mysqli_connect_error());
// 	}
//   $sql = "SELECT * FROM search LIMIT 10";
// 	$result = $mysqli->query($sql);
// 	if (!$result) {
// 		throw new Exception($mysqli->error);
// 	}
// 	while($row = $result->fetch_object()) {
// 		$results[] = $row;
// 	}
// }
// catch (Exception $e)
// {
// 	echo 'We are having issues. Here is how to get help.';
// }
// print_r($results);
?>
</pre>