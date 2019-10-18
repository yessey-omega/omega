<?php
$search_q=$_POST['search'];
$dbconnect= mysqli_connect('localhost', 'admin', 'admin01SSS', 'test') or die("Ошибка! Не подключилось к БД");
// Perform queries
$result=mysqli_query($dbconnect,"SELECT Country FROM new WHERE MATCH(Country,City) AGAINST ('$search_q' IN BOOLEAN MODE);");
// Associative array
$row=mysqli_fetch_assoc($result);
printf ("%s\n",$row["Country"]);
?>
