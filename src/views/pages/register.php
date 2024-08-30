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

            <label class="padding-left-5" for="birthdate">Data de nascimento:</label>
            <input placeholder="Insira sua data de nascimento" class="input" type="date" name="birthdate" max="<?php echo date('Y-m-d'); ?>" required />

            <input placeholder="Digite seu e-mail" class="input" type="email" name="email" required />

            <input placeholder="Digite sua senha" class="input" type="password" name="password" required />

            <?php if (isset($flash)): ?>
                <p class="flash-error"><?= $flash; ?></p>
            <?php endif; ?>

            <input class="button" type="submit" value="Cadastrar" />

            <a href="<?= $base; ?>/login">Já possui uma conta? Entre aqui!</a>
        </form>
    </section>
</body>

</html>