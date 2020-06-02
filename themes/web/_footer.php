<footer class="w-100 main_footer">
    <div class="container pt-5 pb-3">
        <div class="row text-center text-lg-left">
            <div class="col-12 col-sm-6 col-lg-2 mb-5">
                <article class="d-flex flex-column">
                    <h3 class="main_footer_title">Midiaagro</h3>
                    <a href="<?= url("/sobre") ?>" class="main_footer_link mb-2" title="Sobre nós">Sobre nós</a>
                    <a href="<?= url("/fale-conosco") ?>" class="main_footer_link mb-2" title="Fale Conosco">Fale Conosco</a>

                    <div class="mt-2">
                        <a target="_blank" href="https://www.facebook.com/<?= CONF_SOCIAL_FACEBOOK_PAGE ?>" class="main_footer_social_link icon-facebook-official icon-notext"
                           title="Acompanhe-nos no Facebook"></a>
                        <a target="_blank" href="https://www.instagram.com/<?= CONF_SOCIAL_INSTAGRAM_PAGE ?>" class="main_footer_social_link icon-instagrem icon-notext"
                           title="Acompanhe-nos no Instagram"></a>
                    </div>
                </article>
            </div>

            <div class="col-12 col-sm-6 col-lg-2 mb-5">
                <article class="d-flex flex-column">
                    <h3 class="main_footer_title">Mais Vistas</h3>
                    <?php if ($moreReadsCat): foreach ($moreReadsCat as $post): ?>
                        <a href="<?= url("/em/{$post->category()->uri}"); ?>" class="main_footer_link mb-2"
                           title="<?= $post->category()->title; ?>"><?= $post->category()->title; ?></a>
                    <?php endforeach; endif; ?>
                </article>
            </div>

            <div class="col-12 col-sm-6 col-lg-5 mb-5">
                <article>
                    <h3 class="main_footer_title">Receba novidades em seu e-mail!</h3>
                    <form action="https://app.convertkit.com/forms/1435472/subscriptions" method="post" class="ajax_off">
                        <label class="form-group">
                            <input class="form-control" type="text" name="fields[first_name]" placeholder="Seu nome:" required>
                        </label>
                        <label class="form-group">
                            <input class="form-control" type="email" name="email_address" placeholder="Seu melhor e-mail:" required>
                        </label>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-lg">Cadastrar!</button>
                        </div>
                    </form>
                </article>
            </div>

            <div class="col-12 col-sm-6 col-lg-3 mb-5">
                <div class="fb-page" data-href="https://www.facebook.com/<?= CONF_SOCIAL_FACEBOOK_PAGE; ?>/" data-tabs="" data-width=""
                     data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false"
                     data-show-facepile="true">
                    <blockquote cite="https://www.facebook.com/<?= CONF_SOCIAL_FACEBOOK_PAGE; ?>/" class="fb-xfbml-parse-ignore"><a
                                href="https://www.facebook.com/<?= CONF_SOCIAL_FACEBOOK_PAGE; ?>/"><?= CONF_SITE_NAME; ?></a></blockquote>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="main_footer_social_dev d-flex justify-content-end align-items-center pt-3">
                <a href="https://www.hoonz.com.br" title="Desenvolvido pela Agência Hoonz" target="_blank">
                    <img src="<?= theme("/assets/images/hoonz.png"); ?>" alt="hoonz">
                </a>
            </div>
        </div>
    </div>

    <div class="main_footer_copy">
        <p>&copy; 2020 midiaagro | <a href="<?= url("/termos"); ?>" class="text_secondary" title="Termos de uso">Termos
                de uso</a></p>
        <p>Todos os direitos reservados</p>
    </div>
</footer>

<?php $v->start("scripts"); ?>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v7.0&appId=<?= CONF_SOCIAL_FACEBOOK_APP; ?>&autoLogAppEvents=1"></script>

<script async src="https://platform.twitter.com/widgets.js"></script>
<?php $v->end(); ?>