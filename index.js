console.log("index.js started");

$(document).ready(function() {


    setTimeout(function() {
        $(".se-pre-con").fadeOut(300);
    }, 500);

    selectChange();

    var select = document.getElementById("cikkek");
    for (index in result) {
        select.options[select.options.length] = new Option(result[index].cikk, index);
    }



    var selectHova = document.getElementById("cikkHova");
    var raktarHovaNevek = [];

    for (index in resultHova) {
        var raktarNev = resultHova[index].raktarNev;
        var xKord = resultHova[index].xkord;
        var yKord = resultHova[index].ykord;
        var zKord = resultHova[index].zkord;
        raktarHovaNevek.push(raktarNev);

    }

    let uniqueraktarHovaNevek = [...new Set(raktarHovaNevek)];

    for (i in uniqueraktarHovaNevek) {

        selectHova.options[selectHova.options.length] = new Option(uniqueraktarHovaNevek[i]);
    }



    $('#cikkHovaXYZ').prop('disabled', true);
    $('#mennyRange').prop('disabled', true);
    $('#mennyRange').val(0);
    $('#mennyRangeSzam').html(null);
    $('.sel').select2();
    VjszOnOff(0);



    console.log("index.js ended");
});











const resultFunc = (x) =>
    result[$(x).val()];


const resultHovaFunc = (x) => {
    var selectResult = resultHova.filter(({ cikk }) => cikk === resultFunc('#cikkek').cikk);
    return selectResult[$(x).val()];
}


const resultKeresMenny = () =>
    keresMenny[$('Mennyiseg').val()];


const mennyRangeChange = () =>
    $('#mennyRangeSzam').html($('#mennyRange').val());


const selectChange = () =>
    $('#myHeader').html($('#menu').val());



const selectRaktar = () => {
    var selectedHova = cikkHova.options[cikkHova.selectedIndex].value;
    $('#valasztottRaktar').val(selectedHova);

    var raktarDetails = [];

    for (const element of resultHova) {
        element.raktarNev === selectedHova ? raktarDetails.push({ 'xkord': element.xkord, 'ykord': element.ykord, 'zkord': element.zkord }) : "";
    }

    $('#cikkHovaXYZ').prop('disabled', false);
    var selectHovaXYZ = document.getElementById("cikkHovaXYZ");
    $('#cikkHovaXYZ').empty();

    var uniqueRaktarNevek = [];

    for (i in raktarDetails) {
        var xKord = raktarDetails[i].xkord;
        var yKord = raktarDetails[i].ykord;
        var zKord = raktarDetails[i].zkord;

        uniqueRaktarNevek.push(xKord + "-" + yKord + "-" + zKord);
    }

    uniqueRaktarNevek = [...new Set(uniqueRaktarNevek)]

    console.log(uniqueRaktarNevek);

    for (i in uniqueRaktarNevek) {
        selectHovaXYZ.options[selectHovaXYZ.options.length] = new Option(uniqueRaktarNevek[i], uniqueRaktarNevek[i]);
    }

    selectCelKoord();

}



const VjszOnOff = (x) =>
    x == 0 ? ($('#vjsz').prop('disabled', true), $('#vjsz').val("")) : ($('#vjsz').prop('disabled', false), $('#vjsz').focus());


const submitAlert = () => {

    if ($('#mennyRange').val() === '0') {
        var valid = false;
    }

    if (valid == false) {
        alert('Küldés nem sikerült! \nA Mennyiség nem lehet 0!');
        return false;
    } else {
        return true;
    }
}


const cikkekChange = () => {
    $('#valasztottCikk').val(resultFunc('#cikkek').cikk);
    var forrasRaktarSelect = document.getElementById("forrasRaktar");
    var length = forrasRaktarSelect.options.length;
    for (i = length - 1; i >= 0; i--) {
        forrasRaktarSelect.options[i] = null;
    }

    const helper = (x) => {
        return x[index].raktarNev + "-" + x[index].xkord + "-" + x[index].ykord + "-" + x[index].zkord;
    }


    var keresettCikkForras = resultHova.filter(({ cikk }) => cikk === resultFunc('#cikkek').cikk);
    for (index in keresettCikkForras) {
        forrasRaktarSelect.options[forrasRaktarSelect.options.length] = new Option(
            helper(keresettCikkForras), index);
    }
    forrasRaktarMenny();
}

const forrasRaktarMenny = () => {
    $('#mennyRange').prop('disabled', false);
    $('#mennyRange').prop('max', resultHovaFunc('#forrasRaktar').mennyiseg);
    $('#mennyRange').val(resultHovaFunc('#forrasRaktar').mennyiseg);
    mennyRangeChange();
    console.log("forras raktár");


    var keresett = resultHova.filter(({ cikk }) => cikk === resultFunc('#cikkek').cikk)[$('#forrasRaktar').val()];

    $('#valasztottForrasRaktar').val(keresett.raktarNev + "-" + keresett.xkord + "-" + keresett.ykord + "-" + keresett.zkord);
    // $('#mennyRange').prop('max', keresResult3);
    // $('#mennyRange').val(keresResult3);
}


const selectCelKoord = () =>
    $('#valasztottCelRaktar').val($('#cikkHova').val() + "-" + $('#cikkHovaXYZ').val());