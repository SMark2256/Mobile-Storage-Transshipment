
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

if($_POST['cikknev']){
      $jsVariable = $_POST['cikknev'];



$sql = 'SELECT 
	sum(SS.Available_StaticQuantity) as "Mennyiseg"
    FROM relWMSStockSum SS
        ,relWMSLocation LC
        ,relAc AC
        ,relWMSStore ST
    WHERE SS.ItemNo = AC.MNr
    AND SS.LocationID = LC.LocationID
    AND ST.STORENO = LC.STORENO 
    AND SS.ITEMNO = \''.$jsVariable.'\'
    AND AC.SetType <> 1
    AND LC.StoreNo = UNISTR(\'MEGMSZERSZ\')
    AND LC.X = UNISTR(\'01\')
    AND LC.Y = UNISTR(\'01\')
    AND LC.Z = UNISTR(\'01\')
    AND ST.AddressNo = \'00002-02\'
    GROUP BY 
	    SS.ITEMNO
	    , AC.KTXT 
	    , LC.X 
		, LC.Y 
		, LC.Z
		, SS.QuantityUnit
		, LC.StoreNo
    ORDER BY SS.ItemNo';

    $result = connect($sql);

    $rows = array();

    while($r = oci_fetch_array($result, OCI_ASSOC)) {
        $rows[] = $r;
    }

    json_encode($rows);

}

?>