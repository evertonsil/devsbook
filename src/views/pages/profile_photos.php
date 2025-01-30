<?= $render('header', ['loggedUser' => $loggedUser]); ?>
    <section class="container main">
        <!-- Chamada da View Sidebar -->
        <?= $render('sidebar', ['activeMenu' => 'photos']); ?>
        <section class="feed">
            <!--Renderizando partial do header profile-->
            <?= $render('profile-header', ['loggedUser' => $loggedUser, 'user' => $user, 'isFollowing' => $isFollowing]); ?>
            <div class="row">
                <div class="column">
                    <div class="box">
                        <div class="box-body">
                            <div class="full-user-photos">
                                <?php if (count($user->photos) == 0): ?>
                                    <p>Nenhuma foto encontrada.</p>
                                <?php endif; ?>

                                <?php foreach ($user->photos as $photo): ?>
                                    <div class="user-photo-item">
                                        <a href="#modal-<?= $photo->id ?>" rel="modal:open">
                                            <img src="<?= $base ?>/media/uploads/<?= $photo->body ?>"/>
                                        </a>
                                        <div id="modal-<?= $photo->id ?>" style="display:none">
                                            <img src="<?= $base ?>/media/uploads/<?= $photo->body ?>"/>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
<?= $render('footer'); ?>