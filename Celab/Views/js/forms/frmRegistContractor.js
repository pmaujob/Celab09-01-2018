emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

function onLoadRegistContractor() {
    
    $(document).ready(function () {
        $('select').material_select();
    });

    jQuery.ajax({
        type: 'POST',
        url: 'http://localhost/Celab/Celab/Controllers/GetContIdentType.php',
        async: true,
        data: {op: 1},
        timeout: 0,
        success: function (respuesta) {
            
            var vitypes = JSON.parse(respuesta);
            for (var i = 0; i < vitypes.length; i++) {

                var vitype = vitypes[i];
                var option = document.createElement('option');
                option.value = vitype.id + "|" + vitype.dv;
                option.innerHTML = vitype.des;

                $('#listTipo').append(option);
            }
            $("#listTipo").material_select('update');

        }, error: function () {
            alert('Unexpected Error');
            return;
        }
    });

}

function validateDV(select) {
    var opValue = select.value.toString().split('|')[1];
    document.getElementById('divDv').style.display = opValue == 1 ? "" : "none";
}

function saveInfo() {

    var funFirstName = document.getElementById('funFirstName');
    var funLastName = document.getElementById('funLastName');
    var listTipo = document.getElementById('listTipo');
    var funId = document.getElementById('funId');
    var dv = document.getElementById('dv');
    var emailId = document.getElementById('emailId');
   
    if (funFirstName.value.toString().trim().length == 0) {
        alert('Debe ingresar su nombre.');
        funFirstName.focus();
        return;
    }

    if (funLastName.value.toString().trim().length == 0) {
        alert('Debe ingresar su apellido.');
        funLastName.focus();
        return;
    }

    if (listTipo.value == 0) {
        alert('Debe escoger un tipo de documento.');
        listTipo.focus();
        return;
    }

    if (funId.value.toString().trim().length == 0) {
        alert('Debe ingresar su documento de identidad.');
        funId.focus();
        return;
    }

    if (document.getElementById('divDv').style.display != "none" && dv.value.toString().trim().length == 0) {
        alert('Debe ingresar el dígito de verificación');
        dv.focus();
        return;
    }

    //Se muestra un texto a modo de ejemplo, luego va a ser un icono
    if (!emailRegex.test(emailId.value)) {
        alert('El email NO es válido.');
        emailId.focus();
        return;
    }

    var contractorData = new Array();
    contractorData.push(funFirstName.value);
    contractorData.push(funLastName.value);
    contractorData.push(listTipo.value.toString().split('|')[0]);
    contractorData.push(funId.value);
    contractorData.push(dv.value);
    contractorData.push(emailId.value);

    jQuery.ajax({
        type: 'POST',
        url: 'http://localhost/Celab/Celab/Controllers/CRegistContractor.php',
        async: true,
        data: {contractorData: contractorData},
        timeout: 0,
        success: function (respuesta) {

            switch (respuesta.toString().trim()) {

                case "1":
                    alert("Los datos fueron registrados satisfactoriamente.");
                    location.href = "";//llevar a generar el certificado
                    break;

                case "-1":
                    alert("El documento de identidad ingresado ya existe.");
                    funId.focus();
                    break;

                default:
                    console.log("ERROR: " + respuesta.toString().trim());
                    alert("No se pudo realizar el registro de datos, por favor vuelva a intentarlo.");
                    break;

            }


        }, error: function () {
            alert('Unexpected Error');
            return;
        }
    });


}

