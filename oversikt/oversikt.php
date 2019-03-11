<?php
require_once 'DBOversikt.php';
$pdo = new DBOversikt();

$result = $pdo->stemmestedOversikt();
$resultAnsatt = $pdo->ansattOversikt();

?>
<html>
<head>
    <title>Oversikt</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css"></script>
    <script src="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"></script>
    <script src="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"></script>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.js"></script>
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.css">


    <style>
        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 70%;
        }

        th {
            background-color: #8CCCF1;
        }

        #modalContent {
            font-size: 18px;
        }

        .modal-title {
            font-size: 20px;
        }

        #tableOverskrift {
            padding 5px;
            font-size: 25px;
        }
    </style>
</head>
<body>
    <div class="container">

        <div class="row">
            <!-- Modal -->
            <div class="modal fade" id="modal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Oversikt</h4>
                        </div>
                        <div class="modal-body">
                            <span id="modalContent"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default">Administrer</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>

            <h1 id="tableOverskrift">Oversikt over stemmesteder</h1>
            <table id="oversiktStemmested" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>KretsNummer</th>
                    <th>Sted</th>
                    <th>Stemmebærere</th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $i => $value) { ?>
                    <tr>
                        <td data-toggle="modal" data-target="#modal" onclick="krets();"><?php echo $result[$i]['kretsNr']?></td>
                        <td data-toggle="modal" data-target="#modal" onclick="krets();"><?php echo $result[$i]['sted']?></td>
                        <td data-toggle="modal" data-target="#modal" onclick="krets();"><?php echo $result[$i]['stemmeBer']?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <h1 id="tableOverskrift">Oversikt over ansatte</h1>
            <table id="oversiktAnsatte" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>KretsNummer</th>
                    <th>Navn</th>
                    <th>Telefon</th>
                    <th>email</th>
                    <th>Fødselsår</th>
                    <th>leder</th>
                    <th>nestleder</th>
                    <th>sekretær</th>
                    <th>vaktmester</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($resultAnsatt as $i => $value) { ?>
                    <tr>
                        <td data-toggle="modal" data-target="#modal" onclick="ansatt()"><?php echo $resultAnsatt[$i]['kretsNr']?></td>
                        <td data-toggle="modal" data-target="#modal" onclick="ansatt()"><?php echo $resultAnsatt[$i]['navn']?></td>
                        <td data-toggle="modal" data-target="#modal" onclick="ansatt()"><?php echo $resultAnsatt[$i]['telefon']?></td>
                        <td data-toggle="modal" data-target="#modal" onclick="ansatt()"><?php echo $resultAnsatt[$i]['email']?></td>
                        <td data-toggle="modal" data-target="#modal" onclick="ansatt()"><?php echo $resultAnsatt[$i]['fodselsaar']?></td>
                        <td data-toggle="modal" data-target="#modal" onclick="ansatt()"><?php echo $resultAnsatt[$i]['leder']?></td>
                        <td data-toggle="modal" data-target="#modal" onclick="ansatt()"><?php echo $resultAnsatt[$i]['nestLeder']?></td>
                        <td data-toggle="modal" data-target="#modal" onclick="ansatt()"><?php echo $resultAnsatt[$i]['sekreter']?></td>
                        <td data-toggle="modal" data-target="#modal" onclick="ansatt()"><?php echo $resultAnsatt[$i]['vaktmester']?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>


        </div>
    </div>

</body>
<script type="text/javascript">
    function krets() {
        const table = document.getElementById("oversiktStemmested");
        const rows = table.rows;

        for (let i = 1; i < rows.length; i++) {
            rows[i].onclick = (function() {
                const krets = this.cells[0].innerHTML;
                const sted = this.cells[1].innerHTML;
                document.getElementById('modalContent').innerHTML = "Du har valgt krets: " + krets + " " + "Sted: " + sted;
            });
        }
    }

    function ansatt() {
        const table = document.getElementById("oversiktAnsatte");
        const rows = table.rows;

        for (let i = 1; i < rows.length; i++) {
            rows[i].onclick = (function() {
                const navn = this.cells[1].innerHTML;
                document.getElementById('modalContent').innerHTML = "Du har valgt Ansatt: " + navn + " " ;

            })
        }
    }

</script>
</html>
