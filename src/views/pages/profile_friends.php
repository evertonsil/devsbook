<?= $render('header', ['loggedUser' => $loggedUser]); ?>

    <section class="container main">
        <!-- Chamada da View Sidebar -->
        <?= $render('sidebar', ['activeMenu' => 'friends']); ?>
        <section class="feed">
            <!--Renderizando partial do header profile-->
            <?= $render('profile-header', ['loggedUser' => $loggedUser, 'user' => $user, 'isFollowing' => $isFollowing]); ?>
            <div class="row">
                <div class="column">
                    <div class="box">
                        <div class="box-body">
                            <div class="tabs">
                                <div class="tab-item" data-for="followers">
                                    Seguidores
                                </div>
                                <div class="tab-item active" data-for="following">
                                    Seguindo
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-body" data-item="followers">
                                    <?php foreach ($user->followers as $follower): ?>
                                        <div class="full-friend-list">
                                            <div class="friend-icon">
                                                <a href="<?= $base ?>/profile/<?= $follower->id ?>">
                                                    <div class="friend-icon-avatar">
                                                        <img src="<?= $base ?>/media/avatars/<?= $follower->avatar ?>"/>
                                                    </div>
                                                    <div class="friend-icon-name">
                                                        <?= $follower->name ?>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                                <div class="tab-body" data-item="following">

                                    <div class="full-friend-list">
                                        <?php foreach ($user->following as $following): ?>
                                            <div class="friend-icon">
                                                <a href="<?= $base ?>/profile/<?= $following->id ?>">
                                                    <div class="friend-icon-avatar">
                                                        <img src="<?= $base ?>/media/avatars/<?= $following->avatar ?>"/>
                                                    </div>
                                                    <div class="friend-icon-name">
                                                        <?= $following->name ?>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
<?= $render('footer'); ?>