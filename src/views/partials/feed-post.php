<div class="box feed-new">
    <div class="box-body">
        <div class="feed-new-editor m-10 row">
            <div class="feed-new-avatar">
                <img src="<?= $base; ?>/media/avatars/<?= $user->avatar; ?>" />
            </div>
            <div class="feed-new-input-placeholder">O que você está pensando, <?= $user->name; ?>?</div>
            <div class="feed-new-input" contenteditable="true"></div>
            <div class="feed-new-send">
                <img src="assets/images/send.png" />
            </div>
            <!-- Form externo para receber os dados -->
            <form class="feed-new-form" method="POST" action="<?= $base; ?>/post/new">
                <input class="feed-new-input" type="hidden" name="feed-new-data" />
            </form>
        </div>
    </div>
</div>
<!-- Script dentro da view para que seja possível importa-la em qualquer lugar, de forma 100% funcional -->
<script type="text/javascript">
    let feedInput = document.querySelector('.feed-new-input');
    let feedSubmit = document.querySelector('.feed-new-send');
    let feedForm = document.querySelector('.feed-new-form');

    //Escuta o evento click do botão de enviar
    feedSubmit.addEventListener('click', function() {
        //Caputurando o valor digitado no campo "O que você está pensando"
        let data = feedInput.innerText;

        //Caso existir valor, atirbui no form secundário e faz submit
        if (data != '') {
            feedForm.querySelector('input[name="feed-new-data"]').value = data;
            feedForm.submit();
        }
    })
</script>