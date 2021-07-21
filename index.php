<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <title>Zadanie 5</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <script src="scripts/plotly-latest.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
<script>
    let trace1 =
        {
            x: [],
            y: [],
            type: 'scatter',
            name: "Sinus"
        }

    let trace2 =
        {
            x: [],
            y: [],
            type: 'scatter',
            name: "Cosinus"
        }
    let trace3 =
        {
            x: [],
            y: [],
            type: 'scatter',
            name: "Sinus * Cosinus"
        }
</script>
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "Classes/helper/Database.php";

$connection = (new Database())->getConnection();
?>
<div class="card bg-light">
    <article class="card-body mx-auto" style="max-width: 400px;">
        <p id="result"></p>
        <iframe name="votar" style="display:none;"></iframe>
        <form action="index.php" method="post" target="votar">
            <div class="col-12">
                <div class="input-group input-group-lg w-25 mx-auto">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Hodnota a:</span>
                    </div>
                    <input id="value_a" name="value_a" class="form-control">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block "> Submit  </button>
                </div> <!-- form-group// -->
            <div class="form-check form-check-inline d-flex justify-content-center  my-4 ">

                <label  class="form-check-label FORMULA" for="siny">Sin</label>
                <input  class="form-check-input mx-2" type="checkbox" id="siny" name="siny" checked>

                <label  class="form-check-label FORMULA" for="cosx">Cos</label>
                <input  class="form-check-input mx-2" type="checkbox" id="cosx" name="cosx" checked>

                <label  class="form-check-label FORMULA" for="sinxcosx">Sin Cos</label>
                <input  class="form-check-input mx-2" type="checkbox" id="sinxcosx" name="sinxcosx" checked>
            </div>
        </form>


    </article>
</div>
<div id="graph"></div>
<script>
    if (typeof (EventSource) != "undefined"){
        var source = new EventSource("sse.php");
        source.onmessage = function (ev){
            document.getElementById("result").innerHTML = ev.data + "<br>"
            var skuska = JSON.parse(ev.data)
            console.log(ev.data)
            console.log("skuska")
            graphData = []
            trace1['x'].push(skuska.index)
            trace1['y'].push(skuska.sin)
            trace2['x'].push(skuska.index)
            trace2['y'].push(skuska.cos)
            trace3['x'].push(skuska.index)
            trace3['y'].push(skuska.sin_cos)

            if (document.getElementById('siny').checked){

                graphData.push(trace1)
            }
            if (document.getElementById('cosx').checked){

                graphData.push(trace2)
            }
            if (document.getElementById('sinxcosx').checked){

                graphData.push(trace3)
            }
            Plotly.newPlot('graph' , graphData)
        }
    }else {
        document.getElementById("result").innerHTML = "Nejdu ti sse eventy..."
    }

</script>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $value_a = $_REQUEST['value_a'];
    if (!empty($value_a)){
        $statement = $connection->prepare("TRUNCATE TABLE parameter");
        $statement->execute();
        $sql = "INSERT INTO parameter (a) VALUES (?)";
        $stm = $connection->prepare($sql);
        $stm->execute([$value_a]);


    }

}
?>
</body>
</html>
