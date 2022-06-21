<!DOCTYPE html>
<?php 
require_once("select.php"); 
?>
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
            integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

      <!-- Bootstrap 5 CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
            integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
      <!--                 -->
      <link rel="stylesheet" href="css/myCss2.css">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@600&display=swap" rel="stylesheet">
      <!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
      
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
      
      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
      
      <title>Raktározó</title>
</head>
<body>
      <div class="se-pre-con">

      </div>
      <header class="bg-dark">
            <nav class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 navbar fixed-top navbar-expand-sm navbar-dark bg-dark">
                  <div class="" hidden>
                        <div id="navbarCollapse" class="collapse navbar-collapse">
                              <select id="menu" class="nav text-secondary" onchange="selectChange()">
                                    <option class="text-secondary" value="Raktározás">Raktározás</option>
                                    <option class="text-secondary" value="Sztornó">Sztornó</option>
                                    <option class="text-secondary" value="Info">Info</option>
                              </select>
                        </div>
                  </div>
                  <h1 class="unselectable" id="myHeader">

                  </h1>
            </nav>
      </header>
  

      <div id="formContainer" class="align-middle container bg-light col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <form onsubmit="return submitAlert();" method="post" action="insert2.php">
                  <div class=" col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
                                    <label for="muvelet" class="labelmargins form-label unselectable">Művelet</label>
                                    <div id="muvelet" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 btn-group">
                                          <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                <input type="radio" class="btn-check" name="cikkmuvelet" id="btnradio1" value="Athelyez" autocomplete="off" checked
                                                      onclick="VjszOnOff(0)">
                                                <label class="btn btn-outline-primary col-sm-11 col-md-11 col-lg-11 form-label unselectable" for="btnradio1">Áthelyez</label>
                                          </div>

                                          <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4" hidden>
                                                <input type="radio" class="btn-check " name="cikkmuvelet" id="btnradio2" value="Sztorno" autocomplete="off"
                                                      onclick="VjszOnOff(1)">
                                                <label class="btn btn-outline-primary col-sm-11 col-md-11 col-lg-11 form-label unselectable" for="btnradio2" style="border-color: lightgray; color: lightgray; pointer-events:none;">Sztornó</label>
                                          </div>

                                          <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4" hidden>
                                                <input type="radio" class="btn-check " name="cikkmuvelet" id="btnradio3" value="Anyagkiir" autocomplete="off"
                                                      onclick="VjszOnOff(1)">
                                                <label class="btn btn-outline-primary col-xs-11 col-sm-11 col-md-11 col-lg-11 form-label unselectable" for="btnradio3" style="border-color: lightgray; color: lightgray; pointer-events:none;">Anyagkiírás</label>
                                          </div>
                                    </div>
                              </div>

                  <div class="row  col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="col-lg-3">

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                              <label for="cikkek" class=" labelmargins form-label unselectable">Milyen cikket mozgassunk?(MEGMSZERSZ)</label>
                              <select id="cikkek" name="cikkek" class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 form-control sel form-select" onchange="cikkekChange()" required>
                                    <option value="" selected disabled hidden>Keresés cikkek között</option>
                              </select>
                              <input type="text" class="hiddenInput" id="valasztottCikk" name="valasztottCikk"></input>
                        </div>

                        <div class="col-lg-3">

                        </div>
                  </div>

                  <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                              <label for="forrasRaktar" class="labelmargins label-form unselectable">Forrás Raktár</label>
                              <select id="forrasRaktar" name="forrasRaktar" class="form-control sel form-select" onchange="forrasRaktarMenny()" required>
                                    <option value="" selected disabled hidden>Keresés raktárak között</option>
                              </select>
                        </div>
                        <input type="text" class="hiddenInput" id="valasztottForrasRaktar" name="valasztottForrasRaktar"></input>
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                        <label for="cikkHova" class="labelmargins label-form unselectable">Cél Raktár</label>
                              <select id="cikkHova" name="cikkHova" class="form-control sel form-select h-100" onchange="selectRaktar()" required>
                                    <option value="" selected disabled hidden>Keresés raktárak között</option>
                              </select>
                        </div>
                        <input type="text" class="hiddenInput" id="valasztottCelRaktar" name="valasztottCelRaktar"></input>

                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                        <label for="cikkHovaXYZ" class="labelmargins label-form unselectable">Cél Raktár Koordináta</label>
                              <select id="cikkHovaXYZ" name="cikkHovaXYZ" class="form-control sel form-select" onchange="selectCelKoord()" required>
                                    <option value="" selected disabled hidden>X-Y-Z</option>
                              </select>
                        </div>
                  </div>

                  <!-- <div class="row col-md-8 col-xl-12">
                        <div class="col-md-6">
                              <label for="cikkHova" class="label-form unselectable">Raktár Nevek</label>
                              <select id="cikkHova" name="cikkHova" class="form-control sel form-select" onchange="selectRaktar()" required>
                                    <option value="" selected disabled hidden>Keresés raktárak között</option>
                              </select>
                        </div>
                        <input type="text" class="hiddenInput" id="valasztottRaktar" name="valasztottRaktar"></input>


                        <div class="col-md-6">
                              <label for="cikkHovaXYZ" class="label-form unselectable">Koordináta</label>
                              <select id="cikkHovaXYZ" name="cikkHovaXYZ" class="form-control sel form-select" required>
                                    <option value="" selected disabled hidden>X-Y-Z</option>
                              </select>
                        </div>
                  </div> -->

                  <div class="row col-xs-12 col-sm-6 col-md-12 col-lg-12 col-xl-12">
                        <div class="col-xs-2 col-sm-1 col-md-2 col-lg-2 col-xl-2">
                        </div>

                        <div class="col-xs-2 col-sm-1 col-md-2 col-lg-2 col-xl-2">
                        </div>

                        <div class="col-xs-4 col-sm-2 col-md-4 col-lg-4 col-xl-4" hidden>
                              <label for="vjsz" class="labelmargins unselectable">VJSZ:</label>
                              <input id="vjsz" name="vjsz" type="text" class="form-control" autocomplete="off" />
                        </div>

                        <div class="col-xs-4 col-sm-2 col-md-4 col-lg-4 col-xl-4">
                              <label for="mennyRange" class="labelmargins form-label unselectable">Mennyiség:
                                    <input type="number" min="0" max="100" id="mennyRangeSzam" class="bg-light" onchange="mennyRangeChange()"/>
                              </label>
                              <input type="range" class=" form-range form-control-lg" min="0" max="100" id="mennyRange" name="mennyRange" oninput="mennyRangeSzamChange()" />
                        </div>
                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-right">
                        <button type="submit" class="btn btn-primary btn-lg submitbtn submitbtncolor">
                              <span class="btn-label submitbtnicon"><i class="fa fa-check"></i></span>
                              Küldés
                        </button>
                  </div>
            </form>
      </div>


      <p id="resultP">

      </p>

      <footer class="page-footer">
            <div class="footer-copyright text-center py-2">© 2022 Copyright:
                  <a href="http://intranet"> MAGYARMET KFT.</a>
            </div>
      </footer>
</body>

</html>

<script src="index.js"></script>

<script>

var keresResult3;

const cikkSelectChanger = () => {

      $.post( "cikkselect.php", { 'cikknev': JSON.stringify(resultFunc('#cikkek').cikk)})
            .done(function( data ) {
            alert( "Data Loaded: " + data );
            keresResult3 = data;
      });

      // jQuery.ajax({
      //       type: "POST",
      //       url: 'cikkselect.php',
      //       dataType: 'json',
      //       data: {'cikknev': JSON.stringify(resultFunc('#cikkek').cikk)},
            
      // success: function (msg) {
      //                   console.log("obj befutott");
      //                   keresResult3 = msg;
      //             }  
                  
      // });

      cikkekChange();

      console.log("cikkSelectCaller() lefutott!");
}
</script>