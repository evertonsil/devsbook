    <aside class="mt-10">
        <nav>
            <a href="<?= $base; ?>">
                <div class="menu-item <?= ($activeMenu == 'home' ? 'active' : '') ?>">
                    <div class="menu-item-icon">
                        <img src="<?= $base; ?>/assets/images/home-run.png" width="16" height="16" />
                    </div>
                    <div class="menu-item-text">
                        Home
                    </div>
                </div>
            </a>
            <a href="<?= $base; ?>/profile">
                <div class="menu-item <?= ($activeMenu == 'profile' ? 'active' : '') ?>">
                    <div class="menu-item-icon">
                        <img src="<?= $base; ?>/assets/images/user.png" width="16" height="16" />
                    </div>
                    <div class="menu-item-text">
                        Meu Perfil
                    </div>
                </div>
            </a>
            <a href="<?= $base; ?>/friends">
                <div class="menu-item <?= ($activeMenu == 'friends' ? 'active' : '') ?>">
                    <div class="menu-item-icon">
                        <img src="<?= $base; ?>/assets/images/friends.png" width="16" height="16" />
                    </div>
                    <div class="menu-item-text">
                        Amigos
                    </div>
                    <div class="menu-item-badge">
                        33
                    </div>
                </div>
            </a>
            <a href="<?= $base; ?>/photos">
                <div class="menu-item <?= ($activeMenu == 'photos' ? 'active' : '') ?>">
                    <div class="menu-item-icon">
                        <img src="<?= $base; ?>/assets/images/photo.png" width="16" height="16" />
                    </div>
                    <div class="menu-item-text">
                        Fotos
                    </div>
                </div>
            </a>
            <div class="menu-splitter"></div>
            <a href="<?= $base; ?>/settings">
                <div class="menu-item <?= ($activeMenu == 'settings' ? 'active' : '') ?>">
                    <div class="menu-item-icon">
                        <img src="<?= $base; ?>/assets/images/settings.png" width="16" height="16" />
                    </div>
                    <div class="menu-item-text">
                        Configurações
                    </div>
                </div>
            </a>
            <a href="<?= $base; ?>/logout">
                <div class="menu-item <?= ($activeMenu == 'logout' ? 'active' : '') ?>">
                    <div class="menu-item-icon">
                        <img src="<?= $base; ?>/assets/images/power.png" width="16" height="16" />
                    </div>
                    <div class="menu-item-text">
                        Sair
                    </div>
                </div>
            </a>
        </nav>
    </aside>