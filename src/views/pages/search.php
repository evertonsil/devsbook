<?= $render('header', ['loggedUser' => $loggedUser]); ?>

<section class="container main">
    <?= $render('sidebar', ['activeMenu' => 'search']); ?>
    <section class="feed">
        <h2>Resultado para a pequisa de: <?= $searchTerm; ?></h2>
        <div>
            <div class="full-friend-list">
                <?php foreach ($users as $user): ?>
                    <div class="friend-icon">
                        <a href="<?= $base ?>/profile/<?= $user->id ?>">
                            <div class="friend-icon-avatar">
                                <img src="<?= $base ?>/media/avatars/<?= $user->avatar ?>"/>
                            </div>
                            <div class="friend-icon-name">
                                <?= $user->name ?>
                            </div>
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>
</section>
<?= $render('footer'); ?>
