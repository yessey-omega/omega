// подключение к мемкешу
$memcache = new Memcache;
$memcache->connect('localhost',11211); // подключение
$vRevision = 1; // ревизия кеша, пригодиться для принудительного сброса кеша
 
// пример использования     
$getResult = $memcache->get('key_'.$vRevision); // Проверяем наличие кеша, по ключу
if ($getResult) { // если кеш есть
    // то используем его
    $resultData = array();
    $resultData = $getResult;
}else{ // если кеша нет, то
    // делаем запрос к бд, для получения данных
    $sql = mysql_query("
        SELECT * FROM `users`
    ") or die(mysql_error());
    $resultData = array();
    while($r = mysql_fetch_array($sql, MYSQL_ASSOC)){
        $resultData = $r;
    }
    // записываем данные в мемкеш на сутки - 86400 секунд
    $memcache->set('key_'.$vRevision, $resultData, false, 86400);
}
 
// вывод данных
var_dump($resultData);

// #######################################################################

<?php
$search_q=$_POST['search'];
$dbconnect= mysqli_connect('localhost', 'admin', 'admin01SSS', 'test') or die("Ошибка! Не подключилось к БД");
// Perform queries
$result=mysqli_query($dbconnect,"SELECT Country FROM new WHERE MATCH(Country,City) AGAINST ('$search_q' IN BOOLEAN MODE);");
// Associative array
$row=mysqli_fetch_assoc($result);
printf ("%s\n",$row["Country"]);
?>
