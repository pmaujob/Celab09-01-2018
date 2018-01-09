function onLoad(){
    
    document.getElementById('logoc').style.bottom = "0";
    
}

function login() {

    Materialize.Toast.removeAll();

    var email = document.getElementById("in_user").value;
    var pass = document.getElementById("in_pass").value;

    if (email == "" || pass == "") {

        Materialize.toast("Los campos no pueden estar vacios.", 3000);
        var toasts = document.getElementById('toast-container').getElementsByTagName("div");

        for (var i = 0; i < toasts.length; i++) {
            toasts[i].style.background = "#f50057";
            toasts[i].style.fontWeight = "400";
        }

        return;

    }

    jQuery.ajax({
        type: 'POST',
        url: 'Admin/Controllers/CLogin.php',
        async: true,
        data: {email: email, pass: pass, idapp: 1},
        success: function (response) {

            if (response === "Ok") {

                location.href = "Admin/Views/index.php";

            } else if (response === "No") {

                Materialize.toast("El usuario o la contraseña son incorrectos intentelo de nuevo.", 3000);
                var toasts = document.getElementById('toast-container').getElementsByTagName("div");

                for (var i = 0; i < toasts.length; i++) {
                    toasts[i].style.background = "#f50057";
                    toasts[i].style.fontWeight = "400";
                }

            } else {

                Materialize.toast("Error inesperado", 3000);
                var toasts = document.getElementById('toast-container').getElementsByTagName("div");

                for (var i = 0; i < toasts.length; i++) {
                    toasts[i].style.background = "#f50057";
                    toasts[i].style.fontWeight = "400";
                }

                console.log("Error en MlBackup: " + response);

            }

        },

        error: function () {

            Materialize.toast("Error inesperado ajax", 3000);
            var toasts = document.getElementById('toast-container').getElementsByTagName("div");

            for (var i = 0; i < toasts.length; i++) {
                toasts[i].style.background = "#f50057";
                toasts[i].style.fontWeight = "400";
            }
        }

    });

}