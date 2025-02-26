<?= $render('header', ['loggedUser' => $loggedUser]);
?>
    <section class="container main">
        <!-- Chamada da View Sidebar -->
        <?= $render('sidebar', ['activeMenu' => 'settings']); ?>
        <div class="form-settings">
            <form method="POST" action="<?= $base ?>/update" enctype="multipart/form-data">

                <h2>Configurações</h2>
                <?php if (isset($flash)): ?>
                    <p class="flash-error"><?= $flash; ?></p>
                <?php endif; ?>
                <div class="mt-2 user-avatar">
                    <?php echo $user->avatar ? '<img width="100" alt="user_avatar" src="' . $base . '/media/avatars/' . $user->avatar . '">' : 'Nenhuma imagem de perfil foi encontrada,'; ?>
                    <label class="padding-left-5" for="avatar">Novo Avatar:</label>
                    <input type="file" name="avatar" accept="image/*"/>
                </div>

                <div class="mt-4 user-cover">
                    <?php echo $user->cover ? '<img width="300" alt="user_cover" src="' . $base . '/media/covers/' . $user->cover . '">' : 'Nenhuma imagem de capa foi encontrada'; ?>
                    <label class="padding-left-5" for="cover">Nova Capa:</label>
                    <input type="file" name="cover" accept="image/*"/>
                </div>


                <hr class="mt-4 mb-4">

                <label class="padding-left-5" for="name">Nome Completo:</label>
                <input value="<?= $user->name; ?>" class="input" type="text" name="name" required/>

                <label class="padding-left-5" for="birthdate">Data de nascimento:</label>
                <input value="<?= date('Y-m-d', strtotime($user->birthdate)); ?>" class="input" type="date"
                       name="birthdate"
                       max="<?php echo date('Y-m-d'); ?>"
                />

                <label class="padding-left-5" for="email">E-mail:</label>
                <input value="<?= $user->email; ?>" class="input" type="email" name="email" readonly required/>

                <label class="padding-left-5" for="city">Cidade:</label>
                <input value="<?= $user->city; ?>" class="input" type="text" name="city"/>

                <label class="padding-left-5" for="work">Trabalho:</label>
                <input value="<?= $user->work; ?>" class="input" type="text" name="work"/>

                <hr class="mt-4 mb-4">

                <h3 class="mb-4">Alterar Senha</h3>
                <label class="padding-left-5" for="password">Nova Senha:</label>
                <input class="input" type="password" name="password"/>

                <label class="padding-left-5" for="confirm-password">Confirmar Nova Senha:</label>
                <input class="input" type="password" name="confirm-password"/>

                <input class="button mt-4" type="submit" value="Atualizar"/>
            </form>
        </div>
    </section>
<?= $render('footer'); ?>