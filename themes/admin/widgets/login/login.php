<?php $v->layout("_login"); ?>

<div class="login">
    <article class="login_box rounded-lg">
        <h1 class="hl icon-user">Login</h1>
        <div class="ajax_response"><?= flash(); ?></div>

        <form name="login" action="<?= url("/admin/login"); ?>" method="post">
            <label>
                <span class="field icon-envelope">E-mail:</span>
                <input name="email" type="email" placeholder="Informe seu e-mail" required/>
            </label>

            <label>
                <span class="field icon-unlock-alt">Senha:</span>
                <input name="password" type="password" placeholder="Informe sua senha:" required/>
            </label>

            <button class="rounded gradient gradient-blue gradient-hover icon-sign-in">Entrar</button>
        </form>
    </article>
</div>