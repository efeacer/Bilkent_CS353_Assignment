<?php
// Destroy any previous session
session_start();
session_unset();
session_destroy();
?>

<!doctype html>
<html>
    <head>
        <meta charset='utf-8'/>
        <link rel='stylesheet' type='text/css'
              href='http://fonts.googleapis.com/css?family=Spectral'>
        <title>ACER BANK</title>
    </head>
    <style>
        * {
           font-family: Spectral;
           font-size: 20px;
           text-align: center;
        }
        h1 {
            font-size: 40px;
        }
        input {
            width: 200px;
            margin-bottom: 10px;
            border-radius: 10px;
        }
        button {
            width: 150px;
            margin-top: 10px;
            border-radius: 10px;
            background-color: #4CAF50;
            color: white;
        }
        button:hover {
            box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),
                        0 17px 50px 0 rgba(0,0,0,0.19);
        }
    </style>
    <body>
    <h1>ACER BANK</h1>
    <div id='login'>
    <form method='post' onsubmit='return validateForm();' action='login.php'>
        Username:<br>
        <input type='text' id='usernameInput' name='username' required><br>
        Password:<br>
        <input type='password' id='passwordInput' name='password' required><br>
        <button type='submit'>Login</button>
        </form>
    </div id='login'>
    </body>
</html>
