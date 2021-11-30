<?php
    include("alert.html");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In | Reddot</title>

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;500&display=swap" rel="stylesheet">
    
    <script src="js/jquery-3.6.0.min.js"></script>

    <style>
        html {
            height: 100%;
        }

        body{
            background-image: url('bg-star.jpg');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }

        * {
            font-family: 'Poppins', sans-serif;
        }

        .text-indigo {
            color: #6610f2 !important;
        }

        .bg-indigo {
            background-color: #6610f2 !important;
        }
    </style>
</head>


<body class="h-100">
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-4 d-flex justify-content-center align-items-center">
                <div class="card p-4" style="width: 20rem">
                    <h2 class="text-indigo" style="font-weight: 500;">Log In</h2>
                    <form id="myForms" method="POST" name="form_login" class="mt-3" style="font-weight: 300;">
                        <div class="mb-3">
                          <label for="input-email" class="form-label">Username/Email address</label>
                          <input type="text" name="email" class="form-control" id="input-user" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                          <label for="input-password" class="form-label">Password</label>
                          <input type="password" name="password" class="form-control" id="input-password">
                        </div>
                        <button type="button" id="Login" name="Login" class="btn w-100 text-white bg-indigo">Login</button>
                    </form>

                    <div class="container text-center mt-3" style="font-weight: 300">
                        <a href="register.php" class="text-secondary text-decoration-none">Create an account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#Login').on('click', function() {
                var username = $('#input-user').val();
                var password = $('#input-password').val();
                if(username != "" && password != "" ){
                    $.ajax({
                        url: "controllers/logreg.php",
                        type: "POST",
                        data: {
                            type:"LOGIN",
                            username: username,
                            password: password						
                        },
                        success: function(response){
                            console.log(response);
                            var response = JSON.parse(response);
                            if(response.statusCode==200){
                                location.href = "home.php";						
                            }else if(response.statusCode==404){
                                $('#error').html('Password/Email salah!');
                                $('#header').html('Not Found');
                                $('#myModal').modal('show');
                            }
                            
                        }
                    });
                }
                else{
                    $('#error').html('Semua kolom harus diisi!');
                    $('#header').html('Empty Field');
                    $('#myModal').modal('show');
                }
            });
        });
    </script>
</body>
</html>