<?php $v->layout("_theme"); ?>

<section class="blog">
    <header class="container blog_header">
        <h1 class="blog_header_title"><?= $title ?? "Blog" ?></h1>
        <p class="mb-2 blog_header_desc"><?= ($search ?? $desc ?? "CONFIRA NOSSOS ÚLTIMOS ARTIGOS"); ?></p>
        <span class="blog_header_border"></span>
    </header>

    <?php if (empty($blog) && !empty($search)): ?>
        <div class="container empty_content">
            <div class="row">
                <div class="col-12 col-lg-8 content mx-auto my-xl-3 text-center">
                    <h2 class="mb-3">Sua pesquisa não retornou resultados :/</h2>
                    <p class="mb-3">Você pesquisou por: <b><?= $search ?></b>. Tente outros termos!</p>
                </div>
            </div>
        </div>
    <?php elseif (empty($blog)): ?>
        <div class="container empty_content">
            <div class="row">
                <div class="col-12 col-lg-8 mx-auto my-xl-3 text-center">
                    <img class="mb-3 rounded-lg" src="<?= theme("/assets/images/empty-content.jpg"); ?>"
                         alt="Ainda estamos trabalhando aqui!">
                    <h2 class="mb-3">Ainda estamos trabalhando aqui!</h2>
                    <p class="">Nossos editores estão preparando um conteúdo de primeira para
                        você.</p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="container pb-4">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <?php foreach ($blog as $post): ?>
                            <?php $v->insert("blog-list", [
                                "post" => $post,
                                "class" => "col-6 col-md-4 mb-4"
                            ]); ?>
                        <?php endforeach; ?>

                        <?= $paginator; ?>
                    </div>
                </div>

<!--                <div class="col-12 col-lg-3">-->
<!--                    <div class="col-12 mb-4 j_ads">-->
<!--                        <a target="_blank" href="http://www.google.com.br" title="Abapa - 20 Anos">-->
<!--                            <img src="https://placehold.it/253x253" alt="Abapa - 20 Anos">-->
<!--                        </a>-->
<!--                        <a target="_blank" href="http://www.google.com.br" title="Abapa - 20 Anos">-->
<!--                            <img src="https://placehold.it/253x253" alt="Abapa - 20 Anos">-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
    <?php endif; ?>
</section>
