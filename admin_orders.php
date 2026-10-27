<?php

include"config.php";

$result=$conn->query("SELECT * FROM orders");

while($row=$result->fetch_assoc()) {
    echo"Objednávka ".$row['id']." -".$row["date"]."<br>";

}