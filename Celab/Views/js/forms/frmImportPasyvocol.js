var noPensionerArray = new Array();

function onLoadBody() {

    $(document).ready(function () {

    });

    $('.modal').modal();
    $('#waitModal').modal({
        dismissible: false
    });
}

function readFile(input) {

    var ext = (input.value.substring(input.value.lastIndexOf("."))).toLowerCase();
    if (ext !== '.csv') {
        alert("Debe seleccionar un archivo en formato CSV");
        input.value = null;
        return;
    }

    var file = input.files[0];

    var reader = new FileReader();
    reader.readAsText(file, 'ISO-8859-1');

    reader.onload = loadHandler;
    reader.onerror = errorHandler;

}

function loadHandler(event) {

    var csv = event.target.result;
    var allTextLines = csv.split(/\r\n|\n/);

    if (allTextLines.length == 0) {
        alert("Al parecer, el archivo escogido no tiene datos.");
        return;
    }

    for (var i = 0; i < allTextLines.length; i++) {
        var data = allTextLines[i].split(';');
        if (data != "") {
            var person = new Array();
            for (var j = 0; j < data.length; j++) {
                person.push(data[j].toString().trim());
            }
            noPensionerArray.push(person);
        }
    }
}

function errorHandler(evt) {
    if (evt.target.error.name == "NotReadableError") {
        alert("No se pudo leer el archivo, por favor verifíquelo.");
    }
}

function sendData() {

    if (document.getElementById("fileCSV").value == "") {
        alert("Debe escoger un archivo CSV para importar datos.");
        document.getElementById("fileCSV").focus();
    }

    $('#waitModal').modal('open');

    jQuery.ajax({
        type: 'POST',
        url: 'http://localhost/Celab/Celab/Controllers/CImportPasyvocol.php',
        async: true,
        data: {noPensionerArray: noPensionerArray},
        timeout: 0,
        success: function (respuesta) {

            $('#waitModal').modal('close');

            if (respuesta.toString().trim() == '1') {
                alert('Los datos fueron importados con éxito');
                location.href = "frmImportPasyvocol.php";
            } else {
                alert('No se pudo ingresar los datos, error: ' + respuesta);
            }

        }, error: function () {
            $('#waitModal').modal('close');
            alert('Unexpected Error');
        }
    });

}


