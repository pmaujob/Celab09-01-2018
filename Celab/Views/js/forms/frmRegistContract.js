contRegex = /^\d{4,4}-\d{2,2}$/;
valueRegex = /^\d{0,}\.{0,1}\d{1,}$/;
emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
contractArray = new Array();
additionArray = new Array();
contTr = 0;
contAdds = 0;
isEditting = false;
currentRowId = 0;
idContractor = 0;
bdContractor = '';

function onLoadRegistContract() {

    $(document).ready(function () {
        $('select').material_select();
        $('.modal').modal({
            complete: function () {

                if (isEditting) {
                    clearModal();
                    isEditting = false;
                    additionArray = new Array();
                }

            }
        });
        $(".onlyNumbers").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // Allow: Ctrl+A, Command+A
                            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // Allow: home, end, left, right, down, up
                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // let it happen, don't do anything
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });
    });

    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 16, // Creates a dropdown of 15 years to control year,
        today: 'Hoy',
        labelMonthNext: 'Mes Siguiente',
        labelMonthPrev: 'Mes Anterior',
        labelMonthSelect: 'Selecciona un mes',
        labelYearSelect: 'Selecciona un año',
        monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
        weekdaysLetter: ['D', 'L', 'M', 'X', 'J', 'V', 'S'],
        clear: 'Limpiar',
        close: 'Cerrar',
        closeOnSelect: false // Close upon selecting a date,
    });

    jQuery.ajax({
        type: 'POST',
        url: 'http://localhost/Celab/Celab/Controllers/GetContIdentType.php',
        async: true,
        data: {op: 2},
        timeout: 0,
        success: function (respuesta) {

            var vitypes = JSON.parse(respuesta);
            for (var i = 0; i < vitypes.length; i++) {

                var vitype = vitypes[i];
                var option = document.createElement('option');
                option.id = "typeContractItem" + vitype.id;
                option.value = vitype.id;
                option.innerHTML = vitype.des;

                $('#listContrato').append(option);
            }
            $("#listContrato").material_select('update');

        }, error: function () {
            alert('Unexpected Error');
        }
    });
}

function acceptNewContractor() {

    getContractorData();
    contractArray = new Array();
    additionArray = new Array();
    document.getElementById('divContracts').className += " hideControl";
    document.getElementById("tblContractorInfo").className += " hideControl";
    document.getElementById('divButtonRegist').className += " hideControl";

    $("#infoModal").modal('close');

}

function searchContractor(event) {

    if (event != null && event.keyCode != 13) {
        return;
    }

    var inputContractor = document.getElementById('inputContractor');
    if (inputContractor.value.toString().trim().length == 0) {
        alert('Debe digitar un nombre o número de documento para realizar la búsqueda.');
        return;
    }

    if (contractArray.length > 0) {
        $("#infoModal").modal("open");
    } else {
        getContractorData();
    }

}

function getContractorData() {

    var inputContractor = document.getElementById('inputContractor');

    document.getElementById("tblContractor").style.display = "";
    document.getElementById("tableContracts").innerHTML = "";
    document.getElementById('divPreloader').classList.remove("hideControl");

    jQuery.ajax({
        type: 'POST',
        url: 'http://localhost/Celab/Celab/Views/dinamicForms/frmSearchContractor.php',
        async: true,
        data: {op: 1, fill: inputContractor.value},
        timeout: 0,
        success: function (respuesta) {

            document.getElementById('tblContractor').innerHTML = respuesta;
            document.getElementById('divPreloader').className += " hideControl";

        }, error: function () {
            alert('Unexpected Error');
            document.getElementById('divPreloader').className += " hideControl";
        }
    });

}

function selectContractor(idCon, name, doc, email, bd) {

    idContractor = idCon != -1 ? idCon : doc;
    bdContractor = bd;
    document.getElementById("tblContractorInfo").classList.remove("hideControl");

    document.getElementById("tdName").innerHTML = name;
    document.getElementById("tdDoc").innerHTML = "<b>Documento: </b>" + doc;

    if (email != "") {
        document.getElementById("divEmail").style.display = "none";
    }
    document.getElementById("tdEmail").innerHTML = email;
    document.getElementById("tblContractor").style.display = "none";

}

function openModal() {
    document.getElementById('modale').innerHTML = "Agregar Contrato";
    $('#contractModal').modal('open');
}

function closeModal() {
    $('#contractModal').modal('close');
}

function validateChars(event) {
    var contId = document.getElementById('contId');

    if (event.keyCode == 8 && contId.value.toString().length == 6) {
        contId.value = contId.value.toString().substring(0, 5);
    } else if (event.keyCode != 8 && contId.value.toString().length == 4) {
        contId.value += "-";
    }
}

function addAddition() {

    var adDateSus = document.getElementById("idAdDateSus");
    var adDateFin = document.getElementById("idAdDateFin");
    var adValue = document.getElementById("idAdValue");

    var susYear = $('#idAdDateSus').pickadate('picker').get('highlight', 'yyyy');
    var susMonth = $('#idAdDateSus').pickadate('picker').get('highlight', 'mm');
    var susDay = $('#idAdDateSus').pickadate('picker').get('highlight', 'dd');

    var finYear = $('#idAdDateFin').pickadate('picker').get('highlight', 'yyyy');
    var finMonth = $('#idAdDateFin').pickadate('picker').get('highlight', 'mm');
    var finDay = $('#idAdDateFin').pickadate('picker').get('highlight', 'dd');

    var susDate = susYear + "-" + susMonth + "-" + susDay;
    var finDate = finYear + "-" + finMonth + "-" + finDay;

    if (adDateSus.value.toString() == "" && adDateFin.value.toString() == "" && adValue.value.toString() == "") {
        alert("Debe ingresar los datos requeridos");
        return;
    }

    if (adDateSus.value.toString() > "" && adDateFin.value.toString() == "") {
        alert("Debe escoger una fecha de terminación.");
        return;
    } else if (adDateSus.value.toString() == "" && adDateFin.value.toString() > "") {
        alert("Debe escoger una fecha de suscripción.");
        return;
    } else if (susDate > finDate) {
        alert('La Fecha de Suscripción no puede ser mayor a la Fecha de Terminación.');
        idDateSus.focus();
        return;
    }

    if (adValue.value.toString() > 0 && !valueRegex.test(adValue.value)) {
        alert('El valor del contrato ingresado NO es válido.');
        adValue.focus();
        return;
    }

    contAdds++;
    var additionObj = new Array();
    additionObj.push("trAddition" + contAdds);
    additionObj.push(adDateSus.value == "" ? "" : susDate);
    additionObj.push(adDateFin.value == "" ? "" : finDate);
    additionObj.push(adValue.value.toString());
    additionArray.push(additionObj);

    addAdditionRow(additionObj);

    adDateSus.value = "";
    adDateFin.value = "";
    adValue.value = "";

}

function addAdditionRow(additionObj) {

    var tableAddition = document.getElementById("tAddition");

    var trAddition = document.createElement('tr');
    trAddition.id = additionObj[0];

    var tdNo = document.createElement('td');
    tdNo.innerHTML = "" + additionArray.length;
    tdNo.className += "center-align";
    trAddition.appendChild(tdNo);

    var tdDateSub = document.createElement('td');
    tdDateSub.className += "center-align";
    tdDateSub.innerHTML = additionObj[1] == "" ? "-" : additionObj[1];
    trAddition.appendChild(tdDateSub);

    var tdDateFin = document.createElement('td');
    tdDateFin.className += "center-align";
    tdDateFin.innerHTML = additionObj[2] == "" ? "-" : additionObj[2];
    trAddition.appendChild(tdDateFin);

    var tdValue = document.createElement('td');
    tdValue.className += "center-align";
    tdValue.innerHTML = additionObj[3] == "" ? "-" : additionObj[3];
    trAddition.appendChild(tdValue);

    var tdClear = document.createElement('td');
    tdClear.className += "center-align";
    var aClear = document.createElement('a');
    aClear.className = "waves-effect waves-light";
    aClear.href = "#!";

    if (aClear.addEventListener) {  // all browsers except IE before version 9
        aClear.addEventListener("click", function () {
            removeAddition(trAddition.id);
        }, false);
    } else {
        if (aClear.attachEvent) {   // IE before version 9
            aClear.attachEvent("click", function () {
                removeAddition(trAddition.id);
            });
        }
    }

    var aClearIcon = document.createElement('img');
    aClearIcon.src = "../../Publics/images/ic_document_remove.png";
    aClearIcon.className += "icon-addition";
    aClear.appendChild(aClearIcon);
    tdClear.appendChild(aClear);
    trAddition.appendChild(tdClear);

    tableAddition.appendChild(trAddition);

}


function remove(selectedRowId) {

    var selectedRow = document.getElementById(selectedRowId);
    var tBody = document.getElementById("tableContracts");
    tBody.removeChild(selectedRow);

    var index = contractArray.indexOf(selectedRowId);
    contractArray.splice(index + 1, 1);
    contractArray.splice(index, 1);

    var tRows = tBody.getElementsByTagName("tr");

    for (var i = 0; i < tRows.length; i++) {

        var cells = tRows[i].getElementsByTagName("td");
        cells[0].innerHTML = i + 1;


    }

}

function edit(selectedRowId) {

    document.getElementById('modale').innerHTML = "Modificar Contrato";

    isEditting = true;
    currentRowId = selectedRowId.substring(10, selectedRowId.length);
    var selectedData = contractArray[contractArray.indexOf(selectedRowId) + 1];
    var addData = selectedData[6].toString().split(",");

    console.log(currentRowId);

    $('#listContrato').val(selectedData[0]);
    $("#listContrato").material_select('update');
    document.getElementById('contId').value = selectedData[1];
    $('#idDateSus').pickadate('picker').set('select', selectedData[2], {format: 'yyyy-mm-dd'});
    $('#idDateFin').pickadate('picker').set('select', selectedData[3], {format: 'yyyy-mm-dd'});
    document.getElementById('valueId').value = selectedData[4];
    document.getElementById('objectId').value = selectedData[5];

    //llenar tabla para adiciones
    if (addData != "") {
        for (var i = 0; i < addData.length; i += 4) {

            var row = new Array(addData[i], addData[i + 1], addData[i + 2], addData[i + 3]);
            additionArray.push(row);
            addAdditionRow(row);

        }
    }

    $('#contractModal').modal('open');
}

function removeAddition(idTrAdd) {

    var trAddition = document.getElementById(idTrAdd);
    var tAddBody = document.getElementById("tAddition");
    tAddBody.removeChild(trAddition);

    for (var i = 0; i < additionArray.length; i++) {
        var addObj = additionArray[i];

        if (addObj[0] == idTrAdd) {
            additionArray.splice(i, 1);
            break;
        }
    }

    var tAddRows = tAddBody.getElementsByTagName("tr");
    var newCont = 1;
    for (var i = 0; i < tAddRows.length; i++) {

        if (tAddRows[i].id != "") {
            var addCells = tAddRows[i].getElementsByTagName("td");
            addCells[0].innerHTML = newCont;
            newCont++;
        }

    }

}

function validateContractData() {

    var listContrato = document.getElementById('listContrato');
    var contId = document.getElementById('contId');
    var idDateSus = document.getElementById('idDateSus');
    var idDateFin = document.getElementById('idDateFin');
    var valueId = document.getElementById('valueId');
    var objectId = document.getElementById('objectId');

    var susYear = $('#idDateSus').pickadate('picker').get('highlight', 'yyyy');
    var susMonth = $('#idDateSus').pickadate('picker').get('highlight', 'mm');
    var susDay = $('#idDateSus').pickadate('picker').get('highlight', 'dd');

    var finYear = $('#idDateFin').pickadate('picker').get('highlight', 'yyyy');
    var finMonth = $('#idDateFin').pickadate('picker').get('highlight', 'mm');
    var finDay = $('#idDateFin').pickadate('picker').get('highlight', 'dd');

    if (listContrato.value == 0) {
        alert('Debe escoger un tipo de contrato.');
        listContrato.focus();
        return;
    }

    if (idDateSus.value.toString().length == 0) {
        alert('Debe escoger una Fecha de Suscripción.');
        idDateSus.focus();
        return;
    }

    if (idDateFin.value.toString().length == 0) {
        alert('Debe escoger una Fecha de Terminación.');
        idDateFin.focus();
        return;
    }

    if (!valueRegex.test(valueId.value)) {
        alert('El valor del contrato ingresado NO es válido.');
        valueId.focus();
        return;
    }

    if (objectId.value.toString().length == 0) {
        alert('Debe ingresar el Objeto del contrato.');
        objectId.focus();
        return;
    }

    var susDate = susYear + "-" + susMonth + "-" + susDay;
    var finDate = finYear + "-" + finMonth + "-" + finDay;

    if (susDate > finDate) {
        alert('La Fecha de Suscripción no puede ser mayor a la Fecha de Terminación.');
        idDateSus.focus();
        return;
    }

    var contractData = new Array();
    contractData.push(listContrato.value);//0
    contractData.push(contId.value);//1
    contractData.push(susDate);//2
    contractData.push(finDate);//3
    contractData.push(valueId.value);//4
    contractData.push(objectId.value);//5
    contractData.push(additionArray.length == 0 ? "" : additionArray);//6

    if (isEditting) {
        editContract(contractData);
    } else {
        addContract(contractData);
    }

    clearModal();
    closeModal();
    isEditting = false;

}

function addContract(contractData) {

    contTr++;
    var trId = "trContract" + contTr;
    contractArray.push(trId);
    contractArray.push(contractData);

    var trContract = document.createElement('tr');
    trContract.id = trId;

    var tdNo = document.createElement('td');
    tdNo.innerHTML = "" + contractArray.length / 2;//se divide entre 2 para no contar los id de cada row
    trContract.appendChild(tdNo);

    var tdContractType = document.createElement('td');
    tdContractType.id = "tdContractType" + contTr;
    tdContractType.innerHTML = $("#typeContractItem" + document.getElementById('listContrato').value).html();
    trContract.appendChild(tdContractType);

    var tdContractNum = document.createElement('td');
    tdContractNum.id = "tdContractNum" + contTr;
    tdContractNum.innerHTML = document.getElementById('contId').value;
    trContract.appendChild(tdContractNum);

    var tdEdit = document.createElement('td');
    var aEditContract = document.createElement('a');
    aEditContract.className = "waves-effect waves-light";
    aEditContract.href = "#!";

    if (aEditContract.addEventListener) {  //all browsers except IE before version 9
        aEditContract.addEventListener("click", function () {
            edit(trId);
        }, false);
    } else {
        if (aEditContract.attachEvent) {   //IE before version 9
            aEditContract.attachEvent("click", function () {
                edit(trId);
            });
        }
    }

    var aEditIcon = document.createElement('img');
    aEditIcon.src = "../../Publics/images/ic_document_edit.png";
    aEditIcon.style = "width: 40%; height: 40%;";
    aEditContract.appendChild(aEditIcon);
    tdEdit.appendChild(aEditContract);
    trContract.appendChild(tdEdit);

    var tdRemove = document.createElement('td');

    var aRemoveContract = document.createElement('a');
    aRemoveContract.className = "waves-effect waves-light";
    aRemoveContract.href = "#!";

    if (aRemoveContract.addEventListener) {  // all browsers except IE before version 9
        aRemoveContract.addEventListener("click", function () {
            remove(trId);
        }, false);
    } else {
        if (aRemoveContract.attachEvent) {   // IE before version 9
            aRemoveContract.attachEvent("click", function () {
                remove(trId);
            });
        }
    }

    var aRemoveIcon = document.createElement('img');
    aRemoveIcon.src = "../../Publics/images/ic_document_remove.png";
    aRemoveIcon.style = "width: 40%; height: 40%;";
    aRemoveContract.appendChild(aRemoveIcon);
    tdRemove.appendChild(aRemoveContract);
    trContract.appendChild(tdRemove);

    document.getElementById('tableContracts').appendChild(trContract);
    document.getElementById('divContracts').classList.remove("hideControl");
    document.getElementById('divButtonRegist').classList.remove("hideControl");

}

function editContract(contractData) {

    contractArray[contractArray.indexOf("trContract" + currentRowId) + 1] = contractData;

    var tdContractType = document.getElementById('tdContractType' + currentRowId);
    tdContractType.innerHTML = $("#typeContractItem" + document.getElementById('listContrato').value).html();

    var tdContractNum = document.getElementById('tdContractNum' + currentRowId);
    tdContractNum.innerHTML = document.getElementById('contId').value;

}

function saveContractInfo() {

    if (contractArray.length == 0) {
        alert("No hay ningún contrato ingresado aun.");
        return;
    }

    var emailId = document.getElementById("emailId");
    if (document.getElementById("divEmail").style.display == "" && !emailRegex.test(emailId.value)) {
        alert('El email NO es válido.');
        emailId.focus();
        return;
    }

    jQuery.ajax({
        type: 'POST',
        url: 'http://localhost/Celab/Celab/Controllers/CRegistContract.php',
        async: true,
        data: {idContractor: idContractor, bdContractor: bdContractor, contractArray: contractArray, emailContractor: emailId.value},
        timeout: 0,
        success: function (respuesta) {

            if (respuesta.toString().trim() == 1) {
                alert("Los datos fueron registrados con éxito.");
                location.href = "../Views/frmRegistContract.php";
            } else {
                alert("No se pudieron registrar los datos, vuelva a intentarlo.");
                console.log(respuesta);
            }

        }, error: function () {
            alert('Unexpected Error');
        }
    });
}

function clearModal() {

    $('#listContrato').val('0');
    $('#listContrato').material_select();
    document.getElementById('contId').value = "";
    document.getElementById('idDateSus').value = "";
    $('#idDateSus').pickadate('picker').clear();
    document.getElementById('idDateFin').value = "";
    $('#idDateFin').pickadate('picker').clear();
    document.getElementById('valueId').value = "";
    document.getElementById('objectId').value = "";

    $('#idAdDateSus').pickadate('picker').clear();
    $('#idAdDateFin').pickadate('picker').clear();

    additionArray = new Array();

    var tableAddition = document.getElementById("tAddition");
    var tableRows = tableAddition.getElementsByTagName('tr');
    for (var i = 0; i < tableRows.length; i++) {
        if (tableRows[i].id != "") {
            tableAddition.removeChild(tableRows[i]);
            i--;
        }
    }

}
