$(document).ready(function () {
                    $("#inicio").on("click", function () {
                        window.location = "index.php";
                    });
                    $("#admin").on("click", function () {
                        window.location = "admin.php";
                    });
                    $("#gasto").on("click", function () {
                        window.location = "gasto.php";
                    });
                    $("#gtrabajo").on("click", function () {
                        window.location = "gtrabajo.php";
                    });
                    $("#ngrupo").on("click", function () {
                        window.location = "ngrupo.php";
                    });
                    $("#categorias").on("click", function () {
                        window.location = "categorias.php";
                    });
                    $("#ncategoria").on("click", function () {
                        window.location = "ncategoria.php";
                    });
                    $("#reg").on("click", function () {
                        window.location = "reg.php";
                    });
                    $("#nrep").on("click", function () {
                        window.location = "nrep.php";
                    });
                    $("#perfil").on("click", function () {
                        window.location = "perfil.php";
                    });
                    $("#cpass").on("click", function () {
                        var answer = confirm("Seguro que desea cambiar la contraseña?");
                        if (answer) {
                            window.location = "cpass.php";
                        }
                        
                    });
                    $("#cmail").on("click", function () {
                        window.location = "cmail.php";
                    });
                    $("#invit").on("click", function () {
                        window.location = "invit.php";
                    });
                    $("#dcuenta").on("click", function () {
			var answerd = confirm("Seguro que desea desactivar su cuenta? Si lo hace no podrá volver a logear.");
                        if (answerd) {
                            window.location = "dcuenta.php";
                        }
                                            });
                    $("#cdatos").on("click", function () {
                        window.location = "cdatos.php";
                    });
                    $("#ayuda").on("click", function () {
                        window.location = "ayuda.php";
                    });
                    $("#logout").on("click", function () {
                        window.location = "logout.php";
                    });
                });
	    