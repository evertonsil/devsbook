<!--Chamando da View Header-->
<?= $render('header', ['loggedUser' => $loggedUser]); ?>

<section class="container main">
    <!-- Chamada da View Sidebar -->
    <?= $render('sidebar'); ?>

    <section class="feed mt-10">
        <div class="row">
            <div class="column pr-5">

                <!-- Chamada View Feed Post -->
                <?= $render('feed-post', ['user' => $loggedUser]); ?>

                <?php foreach ($feed['posts'] as $feedItem): ?>
                    <!-- Chamada View Feed Item -->
                    <?= $render('feed-item', [
                        'data' => $feedItem,
                        'loggedUser' => $loggedUser
                    ]); ?>
                <?php endforeach; ?>
                <div class="feed-pagination">
                    <?php for ($page = 0; $page < $feed['qtdPages']; $page++): ?>
                        <a class="<?= ($page == $feed['currentPage'] ? 'active' : '') ?>" href="<?= $base ?>?page=<?= $page; ?>"><?= $page + 1; ?></a>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="column side pl-5">
                <div class="box banners">
                    <div class="box-header">
                        <div class="box-header-text">Patrocinios</div>
                        <div class="box-header-buttons">

                        </div>
                    </div>
                    <div class="box-body">
                        <a href=""><img src="assets/images/php.jpg" /></a>
                    </div>
                </div>
                <div class="box">
                    <div class="box-body m-10">
                        Criado com ❤️ Everton Marques
                    </div>
                </div>
            </div>
        </div>

    </section>
</section>
<!-- Chamada da view Footer -->
<?= $render('footer');
