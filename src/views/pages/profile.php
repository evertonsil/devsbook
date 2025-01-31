<?= $render('header', ['loggedUser' => $loggedUser]); ?>

    <section class="container main">
        <!-- Chamada da View Sidebar -->
        <?= $render('sidebar', ['activeMenu' => 'profile']); ?>
        <section class="feed">
            <!--Renderizando partial do header profile-->
            <?= $render('profile-header', ['loggedUser' => $loggedUser, 'user' => $user, 'isFollowing' => $isFollowing]); ?>
            <div class="row">
                <div class="column side pr-5">
                    <div class="box">
                        <div class="box-body">
                            <div class="user-info-mini">
                                <img src="<?= $base ?>/assets/images/calendar.png"/>
                                <?= date('d/m/Y', strtotime($user->birthdate)); ?>
                            </div>
                            <?php if (!empty($user->city)): ?>
                                <div class="user-info-mini">
                                    <img src="<?= $base ?>/assets/images/pin.png"/>
                                    <?= $user->city; ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($user->work)): ?>
                                <div class="user-info-mini">
                                    <img src="<?= $base ?>/assets/images/work.png"/>
                                    <?= $user->work; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-header m-10">
                            <div class="box-header-text">
                                Seguindo
                                <span>(<?= count($user->following) ?>)</span>
                            </div>
                            <div class="box-header-buttons">
                                <a href="<?= $base ?>/profile/<?= $user->id ?>/friends">ver todos</a>
                            </div>
                        </div>
                        <div class="box-body friend-list">
                            <?php for ($quant = 0; $quant < 9; $quant++) : ?>
                                <?php if (isset($user->following[$quant])): ?>
                                    <div class="friend-icon">
                                        <a href="<?= $base ?>/profile/<?= $user->following[$quant]->id ?>">
                                            <div class="friend-icon-avatar">
                                                <img src="<?= $base ?>/media/avatars/<?= $user->following[$quant]->avatar ?>"/>
                                            </div>
                                            <div class="friend-icon-name">
                                                <?= $user->following[$quant]->name ?>
                                            </div>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                </div>
                <div class="column pl-5">

                    <div class="box">
                        <div class="box-header m-10">
                            <div class="box-header-text">
                                Fotos
                                <span>(<?= count($user->photos) ?>)</span>
                            </div>
                            <div class="box-header-buttons">
                                <a href="<?= $base ?>/profile/<?= $user->id ?>/photos">ver todos</a>
                            </div>
                        </div>
                        <div class="box-body row m-20">
                            <?php for ($quant = 0; $quant < 4; $quant++) : ?>
                                <?php if (isset($user->photos[$quant])): ?>
                                    <div class="user-photo-item">
                                        <a href="#modal-<?= $user->photos[$quant]->id ?>" rel="modal:open">
                                            <img src="<?= $base ?>/media/uploads/<?= $user->photos[$quant]->body ?>"/>
                                        </a>
                                        <div id="modal-<?= $user->photos[$quant]->id ?>" style="display:none">
                                            <img src="<?= $base ?>/media/uploads/<?= $user->photos[$quant]->body ?>"/>
                                        </div>
                                    </div>
                                <?php endif ?>
                            <?php endfor ?>
                        </div>
                    </div>
                    <!-- Chamada View Feed Post -->
                    <?php if ($user->id == $loggedUser->id): ?>
                        <?= $render('feed-post', ['user' => $loggedUser]); ?>
                    <?php endif ?>

                    <?php foreach ($feed['posts'] as $feedItem): ?>
                        <!-- Chamada View Feed Item -->
                        <?= $render('feed-item', [
                            'data' => $feedItem,
                            'loggedUser' => $loggedUser
                        ]); ?>
                    <?php endforeach; ?>
                    <div class="feed-pagination">
                        <?php for ($page = 0; $page < $feed['qtdPages']; $page++): ?>
                            <a class="<?= ($page == $feed['currentPage'] ? 'active' : '') ?>"
                               href="<?= $base ?>/profile/<?= $user->id ?>?page=<?= $page; ?>"><?= $page + 1; ?></a>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </section>
    </section>
<?= $render('footer'); ?>