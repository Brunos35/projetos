<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    <style>
        .container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
        }

        .formbox {
            width: 300px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .formbox h1 {
            margin-bottom: 20px;
        }

        .inputbox {
            margin-bottom: 20px;
            width: 100%;
        }

        .inputbox input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .inputbox label {
            display: block;
            margin-top: 10px;
        }

        .env {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .env:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="formbox" id="box">
            <h1>Redefinir Senha</h1>
            <form action="update_password.php" method="post" autocomplete="on">
                <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                <div class="inputbox">
                    <input type="password" name="new_password" id="new_password" required>
                    <label for="new_password">Nova Senha</label>
                </div>
                <button class="env" type="submit">Redefinir Senha</button>
            </form>
        </div>
    </div>
</body>
</html>
