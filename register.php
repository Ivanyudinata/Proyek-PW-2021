<?php
    require_once("alert.html");


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Reddot</title>

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
                    <h2 class="text-indigo" style="font-weight: 500;">Register</h2>
                    <form action="#" method="GET" onsubmit="return check()" class="mt-3" style="font-weight: 300;">
                        <div class="mb-3">
                          <label for="input-name" class="form-label">Your Name</label>
                          <input type="text" name="nama" class="form-control" id="input-name" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                          <label for="input-email" class="form-label">Username</label>
                          <input type="text" name="username" class="form-control" id="input-username" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                          <label for="input-email" class="form-label">Email address</label>
                          <input type="email" name="email" class="form-control" id="input-email" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col">
                                    <label for="input-password" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="input-password">
                                </div>
                                <div class="col">
                                    <label for="input-confirm-password" class="form-label">Confirm Pass</label>
                                    <input type="password" name="confirm" class="form-control" id="input-confirm-password">
                                </div>
                            </div>
                        </div>
                        
                        <button type="button" id="Register" name="register" class="btn w-100 text-white bg-indigo">Register</button>
                    </form>

                    <div class="container text-center mt-3" style="font-weight: 300">
                        <a href="login.php" class="text-secondary text-decoration-none">Log In</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <script>
        $(document).ready(function() {
			
			function clearinput(){
				$('#input-name').val("");
				$('#input-username').val("");
				$('#input-email').val("");
				$('#input-confirm-password').val("");
				$('#input-password').val("");
			}
            $('#Register').on('click', function() {
                var name = $('#input-name').val();
                var username = $('#input-username').val();
                var email = $('#input-email').val();
                var confirm = $('#input-confirm-password').val();
                var password = $('#input-password').val();
                
                if(username != "" && password != "" && email != "" && confirm != "" && name != "" ){
                    if(password == confirm){
                        $.ajax({
                            url: "controllers/logreg.php",
                            type: "POST",
                            data: {
                                type:"REGISTER",
                                nama: name,
                                username: username,
                                email: email,
                                password: password
                            },
                            success: function(response){
                                console.log(response);
                                var response = JSON.parse(response);
                                if(response.statusCode==403){
                                    $('#error').html('Username/email sudah terdaftar!');
                                    $('#header').html('Error');
                                    $('#myModal').modal('show');	
									clearinput();
                                }
                                else if(response.statusCode==201){
                                    $('#error').html('Berhasil mendaftar!');
                                    $('#header').html('Sukses');
                                    $('#myModal').modal('show');
									clearinput();
                                }else if(response.statusCode==400){
                                    $('#error').html('Gagal mendaftar!');
                                    $('#header').html('Failed');
                                    $('#myModal').modal('show');
                                }
                            }
                        });
                    }else{
                        $('#error').html('Password dan confirm tidak sama!');
                        $('#header').html('Error');
                        $('#myModal').modal('show');
                    }
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