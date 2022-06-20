<html>
    
<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@600&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- Bootstrap 5 CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
            integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
      <!--                 -->
      <link rel="stylesheet" href="css/myCss.css">
      <title>Insert</title>
</head>
<style>
body {
      font-family: 'Noto Sans', sans-serif;
}

header {
      padding-bottom: 10px;
      padding-top: 10px;
      margin-bottom: 50px;
}

h1 {
      text-align: center;
      color: white;
      font-size: 40px;
      pointer-events: none;
}

.alert {
      font-size: 20px;
}

footer {
      font-size: 12px;
}
</style>

<body>
      <header class="bg-dark">

            <h1>Feltöltés...</h1>

      </header>

      <!-- Footer -->
      <footer class="page-footer fixed-bottom">

            <!-- Copyright -->
            <div class="footer-copyright text-center py-2">© 2022 Copyright:
                  <a href="http://www.magyarmet.com"> MAGYARMET KFT.</a>
            </div>
            <!-- Copyright -->

      </footer>
      <!-- Footer -->
</body>

</html>

<?php

require_once('/var/www/html/lib/kapcsolatok.php');

$Honnan = mb_convert_encoding($_POST['valasztottForrasRaktar'] , 'ISO-8859-2', 'WE8PC850');
$Cikk = $_POST['valasztottCikk'];
$Hova = mb_convert_encoding($_POST['valasztottCelRaktar'] , 'ISO-8859-2', 'WE8PC850');
//$HovaXYZ = mb_convert_encoding($_POST['cikkHovaXYZ'], 'ISO-8859-2', 'WE8PC850');
$HovaDE = $Hova;//."-".$HovaXYZ;
$Mennyit = $_POST['mennyRange'];
$Muvelet;
$VJSZ = "";

switch ($_POST['cikkmuvelet']) {
    case 'Athelyez':
        $Muvelet = 'TRANSFER';
        break;

    case 'Sztorno':
        $Muvelet = 'PPCCANCELISSUE';
        $VJSZ = $_POST['vjsz'];
        $Honnan = $HovaDE;
        $HovaDE = NULL;
        break;

    case 'Anyagkiir':
        $Muvelet = 'PPCISSUE';
        $VJSZ = $_POST['vjsz'];
        $Honnan = $HovaDE;
        $HovaDE = NULL;
        break;

    default:
        break;
}


$conn = oracle_connect('test');

$sql = "INSERT INTO RELUSTOOLSAUT (IK,SYSF,CREATEDATE,CREATEUSER, TOOLSOURCE, ITEMNO, ACTIONTYPE, QUANTITY, FEEDBACKNO, STATUS, SOURCESTOCK, DESTINATIONSTOCK, COMMENT0) VALUES (INFOR.MM_NEXT_IK(),'0000087665',SYSDATE,'PHP', 'SZERSZAUT1','".$Cikk."','".$Muvelet."','".$Mennyit."','".$VJSZ."','0','".$Honnan."', '".$HovaDE."','PHP TESZT')";

$stid = oci_parse($conn,$sql);

$done = oci_execute($stid);

if(!$done){

    $m = oci_error($stid);

    Echo' <div class="alert alert-danger text-center" role="alert"> HIBA A FELTÖLTÉS SORÁN! </div>';

}else{

    Echo "<div class='alert alert-success text-center' role='alert'> SIKERES FELTÖLTÉS </div>";
}

Echo '<div class="container col-md-12" style="border:0px;"><div class="row col-md-12"><div class="col-md-4"></div>';
Echo '<div class="card col-md-4" style="border: 0px; text-align:left; pointer-events: none; width: 26rem;">';
Echo '<div class="card-header" style="text-align: center;">';
Echo '  <h3>Felöltött adatok</h3>';
Echo '</div>';
Echo '<ul class="list-group list-group-flush">';
Echo '  <li class="list-group-item">Cikk: '.$Cikk.'</li>';
Echo '  <li class="list-group-item">Honnan: '.$_POST['valasztottForrasRaktar'].'</li>';
Echo '  <li class="list-group-item">Hova: '.$_POST['valasztottCelRaktar'].'</li>';
Echo '  <li class="list-group-item">Mennyit: '.$Mennyit.'</li>';
Echo '  <li class="list-group-item">Művelet: '.$Muvelet.'</li>';
Echo '  <li class="list-group-item">VJSZ: '.$VJSZ.'</li>';
Echo '</ul>';
Echo '</div>';
Echo '<div class="col-md-4"></div>';
Echo '</div>';


header('Refresh: 2; URL=https://intranet2/testing/raktarozo/index3.php');

?>