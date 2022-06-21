
<script>
    
console.log("select.php started");
</script>
<?php

require_once('/var/www/html/lib/kapcsolatok.php');


function connect($sql){

    $conn = oracle_connect('test');

    $sql1 = $sql;

    $stid = oci_parse($conn,$sql1);

    $r = oci_execute($stid);
    
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    return $stid;
}




// Cikknevek select felöltés

$cikkSQL = 'SELECT asciistr(SS.ItemNo) as "cikk"
    , sum(SS.Available_StaticQuantity) as "mennyiseg"
    , SS.QuantityUnit as "egyseg"
    , asciistr(LC.StoreNo) as "tipus"
    , asciistr(LC.X) as "x"
    , asciistr(LC.Y) as "y"
    , asciistr(LC.Z) as "z"
    FROM relWMSStockSum SS
        ,relWMSLocation LC
        ,relAc AC
        ,relWMSStore ST
    WHERE SS.ItemNo = AC.MNr
    AND SS.LocationID = LC.LocationID
    AND ST.StoreNo = LC.StoreNo
    AND AC.SetType <> 1
    AND ST.AddressNo = \'00002-02\'
    AND (SS.ItemNo LIKE \'CNA%\' OR SS.ItemNo LIKE \'CMA%\')
    GROUP BY  SS.QuantityUnit, SS.ItemNo,LC.StoreNo, LC.X , LC.Y, LC.Z
    ORDER BY SS.ItemNo DESC';

$cikkSTID = connect($cikkSQL);

//print_r($cikkSTID);

$rows = oc_stmt_to_array($cikkSTID, ['cikk' => '1', 'tipus' => '1', 'x' => '1', 'y' => '1', 'z' => '1']);

$row2fomatted = array();

for ($i=0; $i < sizeof($rows['cikk']); $i++) { 
    $row2fomatted[$i]['cikk'] .= $rows['cikk'][$i];
    $row2fomatted[$i]['mennyiseg'] .= $rows['mennyiseg'][$i];
    $row2fomatted[$i]['egyseg'] .= $rows['egyseg'][$i];
    $row2fomatted[$i]['tipus'] .= $rows['tipus'][$i];
    $row2fomatted[$i]['x'] .= $rows['x'][$i];
    $row2fomatted[$i]['y'] .= $rows['y'][$i];
    $row2fomatted[$i]['z'] .= $rows['z'][$i];
}


$json = json_encode($row2fomatted);//OUTPUT
?>
<?php




// Raktárnevek select felöltés

$raktarSQL = 'SELECT 
SS.ItemNo AS "cikk"
, asciistr(ST.STORENO) AS "raktarNev"
, asciistr(LC.X) as "xkord"
, asciistr(LC.Y) as "ykord"
, asciistr(LC.Z) as "zkord"
, sum(SS.Available_StaticQuantity) as "mennyiseg"
FROM 
    relWMSStockSum SS
    ,relWMSStore ST
    , relWMSLocation LC
WHERE 
    ST.ADDRESSNO = \'00002-02\'
    AND SS.LocationID = LC.LocationID
    AND ST.STORENO = LC.STORENO
    AND X <> \'0\'
    AND Y <> \'0\'
    AND Z <> \'0\'
    AND UPPER(ST.STORENO) NOT LIKE \'D%\'
GROUP BY 
SS.ItemNo
,ST.STORENO 
, LC.X 
, LC.Y
, LC.Z
ORDER BY ST.STORENO';

$raktarSTID = connect($raktarSQL);

$rows2 = oc_stmt_to_array($raktarSTID, ['raktarNev' => '1', 'xkord' => '1', 'ykord' => '1', 'zkord' => '1']);

$row2fomatted = array();

for ($i=0; $i < sizeof($rows2['raktarNev']); $i++) { 
    $row2fomatted[$i]['cikk'] .= $rows2['cikk'][$i];
    $row2fomatted[$i]['raktarNev'] .= $rows2['raktarNev'][$i];
    $row2fomatted[$i]['xkord'] .= $rows2['xkord'][$i];
    $row2fomatted[$i]['ykord'] .= $rows2['ykord'][$i];
    $row2fomatted[$i]['zkord'] .= $rows2['zkord'][$i];
    $row2fomatted[$i]['mennyiseg'] .= $rows2['mennyiseg'][$i];
}

$json2 = json_encode($row2fomatted);//OUTPUT


?>


<script>

var result = <?php echo $json; ?>;
var resultHova = <?php print_r($json2); ?>;


console.log("select.php ended");
</script>