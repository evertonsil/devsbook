<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página não encontrada - 404</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= $base ?>/assets/css/404.css">
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12 error-container">
                <div class="error-code">404</div>
                <p class="error-message">Oops! A página que você está procurando não foi encontrada.</p>
                <a href="<?= $base; ?>" class="btn btn-primary btn-home">Voltar para a Página Inicial</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>