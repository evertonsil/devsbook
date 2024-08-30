<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Cadastro | Devsbook</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1" />
    <link rel="stylesheet" href="<?= $base ?>/assets/css/login.css" />
</head>

<body>
    <header>
        <div class="container">
            <a href=""><img src="<?= $base; ?>/assets/images/devsbook_logo.png" /></a>
        </div>
    </header>
    <section class="container main">
        <form method="POST" action="<?= $base ?>/register">
            <input placeholder="Digite seu nome" class="input" type="text" name="name" required />

            <input placeholder="Insira sua data de nascimento" class="input" type="date" name="birthdate" required />

            <input placeholder="Digite sua cidade" class="input" type="text" name="city" required />

            <input placeholder="Digite o nome da empresa onde trabalha" class="input" type="text" name="work" required />

            <input placeholder="Digite seu e-mail" class="input" type="email" name="email" required />

            <input placeholder="Digite sua senha" class="input" type="password" name="password" required />

            <input class="button" type="submit" value="Acessar o sistema" />

            <a href="<?= $base; ?>/login">Já possui uma conta? Entre aqui!</a>
        </form>
    </section>
</body>

</html>