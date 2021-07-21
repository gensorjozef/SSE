<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "Classes/helper/Database.php";

$connection = (new Database())->getConnection();
$sql_select = "SELECT a FROM parameter";
$stm_select = $connection->prepare($sql_select);
$stm_select->execute();
$selects = $stm_select->fetch(PDO::FETCH_ASSOC);
$value = $selects["a"];

?>

<?php

function send($index, $sin, $value, $cos, $sin_cos){
    echo "index: $index\n";
    echo "event: message\n";
    echo "data: {\"sin\": \"$sin\" , \"value\": \"$value\" , \"index\": \"$index\", \"cos\": \"$cos\", \"sin_cos\": \"$sin_cos\"}\n\n";
    ob_flush();
    flush();
}

$index = 0;
while (true){
    $stm_select->execute();
    $selects = $stm_select->fetch(PDO::FETCH_ASSOC);
    $value = $selects["a"];
    $sin2_json = json_encode(pow(sin(deg2rad($index )*$value),2));
    $sin2 = pow(sin(deg2rad($index )*$value),2);
    $cos2 = json_encode(pow(cos(deg2rad($index )*$value),2));
    $sin_cos = json_encode(sin(deg2rad($index )*$value)*cos(deg2rad($index )*$value));




    ?>
    <script>


    </script>
<?php
    send($index,$sin2_json,$value,$cos2,$sin_cos);
    sleep(1);
    $index++;
}
