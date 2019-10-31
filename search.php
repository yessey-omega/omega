<?php
$search_q=$_POST['search'];
$mem = new Memcached();
$mem->addServer("127.0.0.1", 11211);

//$search_q=$_POST['search'];
$dbconnect= mysqli_connect('localhost', 'admin', 'admin01SSS', 'test') or die("Ошибка! Не подключилось к БД");
$query = "SELECT Country FROM new WHERE MATCH(Country,City) AGAINST ('$search_q' IN BOOLEAN MODE)";
$querykey = "KEY" . md5($query) or die(mysqli_error($dbconnection));
$result = $mem->get($querykey);
if ($result) {
    print "<p>Данные получены из memcached: " . $result[0] . "</p>";
} else {
    $result = mysqli_fetch_array(mysqli_query($dbconnection, $query)) or die(mysqli_error($dbconnection));
    $mem->set($querykey, $result, 10);
	$row=mysqli_fetch_assoc($result);
	printf ("%s\n",$row["Country"]);
    //print "<p>Данные получены из БД MySQL: " printf ("%s\n",$row["Country"]); "</p>";
    //print "<p>Данные не найдены в memcached.</p><p>Stored in memcached for next time.</p>";
}
?>

//<?php
//$search_q=$_POST['search'];
//$dbconnect= mysqli_connect('localhost', 'admin', 'admin01SSS', 'test') or die("Ошибка! Не подключилось к БД");
// Perform queries
//$result=mysqli_query($dbconnect,"SELECT Country FROM new WHERE MATCH(Country,City) AGAINST ('$search_q' IN BOOLEAN MODE);");
// Associative array
//$row=mysqli_fetch_assoc($result);
//printf ("%s\n",$row["Country"]);
//?>
