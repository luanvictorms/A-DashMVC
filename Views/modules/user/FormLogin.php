<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/Css/styleLogin.css">
    <title>Document</title>
    <link rel="shortcut icon" href="https://as2.ftcdn.net/v2/jpg/03/08/29/09/1000_F_308290978_rwOZyOCskMkppXSzNhIAi5WJTMyp7aqp.jpg" type="image/x-icon" />
</head>
<body>
    <div class="box_login">

        <div>
            <form method="POST" action="/usuario/login">

                <label for="user_name">Nome</label>
                <input class="form-control" id="user_name" name="user_name" type="text">

                <label for="user_pass">Senha</label>
                <input class="form-control" id="user_pass" name="user_pass" type="password">

                <button class="btn btn-dark" type="submit">Logar</button>
            </form>
        </div>

    </div>
</body>
</html>
