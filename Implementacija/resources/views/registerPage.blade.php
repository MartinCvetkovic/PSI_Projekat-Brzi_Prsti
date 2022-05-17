<?php
/**
* Autor:
* Martin Cvetkovic 19/0284
*/
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href={{asset("css/templateStyle.css")}}>
    <title>Brzi prsti</title>
</head>
<body>
    <div class="container">

        <!-- header -->

        <div class="row bg-primary border border-3 border-dark m-4 d-flex align-items-center">
            <div class="col-sm-3">
                
            </div>
            <div class="col-sm-6 text-center">
                <h1>Brzi Prsti</h1>
                <img src="{{ asset("images/logo.png") }}" alt="logo brzi prsti" id="logo" style="height: 50%; width: 50%;">
            </div>
            <div class="col-sm-3">
                
            </div>
        </div>

        <!-- end of header -->

        <div class="row">
            <div class="col-sm-3">
                
            </div>
            <div class="col-sm-6 text-center bg-light d-flex align-items-center justify-content-center">
                <form action="register" method="POST">
                    @csrf
                    <table class="text-left">
                        <tr>
                            <td>Korisničko ime: </td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>E-mail: </td>
                            <td><input type="email"></td>
                        </tr>
                        <tr>
                            <td>Lozinka: </td>
                            <td><input type="password"></td>
                        </tr>
                        <tr>
                            <td>Potvrda lozinke: </td>
                            <td><input type="password"></td>
                        </tr>
                        <tr>
                            <td><button class="btn btn-outline-secondary">Registruj se</button></td>
                            <td><button class="btn btn-outline-secondary" type="button" onclick="location.href='/'">Odustani</button></td>
                        </tr>
                    </table>
                </form>

            </div>
            <div class="col-sm-3">
                
            </div>
        </div>
    </div>
</body>
</html>