<?php $v->layout("_theme"); ?>

<?php if (!empty($highlights) && count($highlights) == 3): ?>
    <section class="container main_highlights mb-4">
        <h2 class="fontzero">Destaques</h2>

        <div class="px-3">
            <div class="row no-gutters">
                <div class="col-12 col-lg-8 mb-2 mb-sm-3 mb-lg-0">
                    <article class="main_highlights_first">
                        <img class="d-block" src="<?= image($highlights[0]->cover, 800, 450) ?>" alt="<?= $highlights[0]->category()->title ?>">
                        <header class="main_highlights_header">
                            <span class="main_highlights_first_category"><?= mb_strtoupper($highlights[0]->category()->title) ?></span>
                            <a class="main_highlights_first_title"
                               href="<?= url("/{$highlights[0]->uri}") ?>"
                               title="<?= $highlights[0]->category()->title ?>">
                                <h3><?= $highlights[0]->title ?></h3>
                            </a>
                        </header>
                    </article>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-lg-12">
                            <article class="main_highlights_second mb-2 mb-lg-0">
                                <img class="d-block" src="<?= image($highlights[1]->cover, 600, 337.5) ?>" alt="<?= $highlights[1]->title ?>">
                                <header class="main_highlights_header">
                                    <span class="main_highlights_second_category"><?= mb_strtoupper($highlights[1]->category()->title) ?></span>
                                    <a class="main_highlights_second_title"
                                       href="<?= url("/{$highlights[1]->uri}") ?>"
                                       title="<?= $highlights[1]->category()->title ?>">
                                        <h3><?= $highlights[1]->title ?></h3>
                                    </a>
                                </header>
                            </article>
                        </div>

                        <div class="col-12 col-sm-6 col-lg-12">
                            <article class="main_highlights_second">
                                <img class="d-block" src="<?= image($highlights[2]->cover, 600, 337.5) ?>" alt="<?= $highlights[2]->title ?>">
                                <header class="main_highlights_header">
                                    <span class="main_highlights_second_category"><?= mb_strtoupper($highlights[2]->category()->title) ?></span>
                                    <a class="main_highlights_second_title"
                                       href="<?= url("/{$highlights[2]->uri}") ?>"
                                       title="<?= $highlights[2]->category()->title ?>">
                                        <h3><?= $highlights[2]->title ?></h3>
                                    </a>
                                </header>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<section class="container main_relevants">
    <h2 class="fontzero">Relevantes</h2>

    <div class="row">
        <?php if(!empty($relevants)): foreach ($relevants as $rel): ?>
            <?= $v->insert("blog-list", [
                "post" => $rel,
                "class" => "col-12 mb-4 col-sm-6 col-lg-3",
                "cat" => true
            ]); ?>
        <?php endforeach; endif; ?>
    </div>
</section>

<!-- ANÚNCIO -->
<div class="container mb-4">
    <div class="row">
        <div class="col-12 mb-2 col-md-6 mb-md-0">
            <div class="j_ads">
                <a href="#" title="">
                    <img src="<?= theme("assets/images/xtreme-academia-ads-538.png") ?>" alt="Xtreme Academia" class="d-block">
                </a>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="j_ads">
                <a href="<?= url("/fale-conosco/Anunciar") ?>" title="Anuncie aqui">
                    <img src="<?= theme("assets/images/anuncie-aqui-ads-538.png") ?>" alt="Anuncie aqui" class="d-block">
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <section class="col-12 col-xl-8 mb-4">
            <header class="section_header">
                <h2 class="section_header_title">Tecnologia</h2>
            </header>

            <div class="row">
                <?php if ($tech1): foreach ($tech1 as $post): ?>
                    <?= $v->insert("blog-list", [
                        "post" => $post,
                        "class" => "col-6 mb-4"
                    ]); ?>
                <?php endforeach; endif; ?>

                <?php if ($tech2): foreach ($tech2 as $post): ?>
                    <div class="col-12 col-sm-6 col-lg-3 col-xl-6 mb-3 mb-lg-0 mb-xl-3">
                        <article class="d-flex d-lg-block d-xl-flex">
                            <div style="flex-basis: 50%;" class="pr-3 pr-lg-0 pr-xl-3">
                                <a title="<?= $post->title; ?>" href="<?= url("/{$post->uri}"); ?>">
                                    <div class="post_cover">
                                        <img src="<?= image($post->cover, 800, 450); ?>"
                                             alt="<?= $post->title; ?>">
                                    </div>
                                </a>
                            </div>
                            <header style="flex-basis: 50%;">
                                <a class="small" href="<?= url("/{$post->uri}"); ?>" title="<?= $post->title; ?>">
                                    <h3 class="post_title"><?= str_limit_chars($post->title, 60,
                                            " [leia mais]"); ?></h3></a>
                            </header>
                        </article>
                    </div>
                <?php endforeach; endif; ?>
            </div>
        </section>

        <section class="col-12 col-xl-4 mb-4">
            <header class="section_header">
                <h2 class="section_header_title">Últimos Eventos</h2>
            </header>

            <div class="row">
                <?php if(!empty($events)): foreach ($events as $post): ?>
                    <div class="col-12 col-sm-6 col-xl-12 mb-4 mb-sm-0 mb-xl-4">
                        <article>
                            <a title="<?= $post->title; ?>" href="<?= url("/{$post->uri}"); ?>">
                                <div class="post_cover">
                                    <img src="<?= image($post->cover, 800, 450); ?>"
                                         alt="<?= $post->title; ?>">
                                </div>
                            </a>
                            <header>
                                <a href="<?= url("/{$post->uri}"); ?>" title="<?= $post->title; ?>">
                                    <h3 class="post_title"><?= str_limit_chars($post->title, 65,
                                            " [leia mais]"); ?></h3></a>
                            </header>
                        </article>
                    </div>
                <?php endforeach; endif; ?>
            </div>
        </section>
    </div>
</div>

<section class="container mb-4">
    <header class="section_header">
        <h2 class="section_header_title">Entrevistas</h2>
    </header>

    <div class="row">
        <?php if ($interview): foreach ($interview as $post): ?>
            <?= $v->insert("blog-list", [
                "post" => $post,
                "class" => "col-12 mb-4 mb-sm-0 col-sm-4",
            ]); ?>
        <?php endforeach; endif; ?>
    </div>

</section>

<div class="container">
    <div class="row">
        <section class="col-12 col-lg-7 col-xl-8 mb-4">
            <header class="section_header">
                <h2 class="section_header_title">Sabores do Campo</h2>
            </header>

            <div class="row">
                <?php if ($camp): foreach ($camp as $key => $post): ?>
                    <?php if ($key == 0): ?>
                        <?= $v->insert("blog-list", [
                            "post" => $post,
                            "class" => "col-12 mb-4",
                            "p" => true,
                            "cat" => false,
                            "tsize" => "post_title_large",
                            "psize" => "small"
                        ]); ?>
                    <?php else: ?>
                        <?= $v->insert("blog-list", [
                            "post" => $post,
                            "class" => "col-6",
                            "p" => true,
                            "cat" => false,
                            "psize" => "small"
                        ]); ?>
                    <?php endif; ?>
                <?php endforeach; endif; ?>
            </div>
        </section>

        <section class="col-12 col-lg-5 col-xl-4 mb-4">
            <header class="section_header">
                <h2 class="section_header_title">Vídeos</h2>
            </header>

            <div class="row">
                <?php if ($videos): foreach ($videos as $post): ?>
                    <?= $v->insert("blog-list", [
                        "video" => ($post->video ? true : false),
                        "post" => $post,
                        "class" => "col-6 col-lg-12 mb-lg-4",
                    ]); ?>
                <?php endforeach; endif; ?>

                <!-- ANÚNCIO -->
                <div class="col-12 col-sm-8 col-md-6 mx-sm-auto col-lg-12 mt-4 mt-md-0 j_ads">
                    <a href="#" title="Ciso Odontologia">
                        <img src="<?= theme("assets/images/ciso-odonto-ads-380.png"); ?>" alt="Ciso Odontologia" class="d-block">
                    </a>
                    <a href="#" title="Divina Marmita">
                        <img src="<?= theme("assets/images/divina-marmita-ads-380.png"); ?>" alt="Divina Marmita" class="d-block">
                    </a>
                </div>
            </div>
        </section>
    </div>
</div>

<section class="container mb-4">
    <header class="section_header">
        <h2 class="section_header_title">Mais Lidos</h2>
    </header>

    <div class="row">
        <?php if ($moreReads): foreach ($moreReads as $post): ?>
            <?= $v->insert("blog-list", [
                "post" => $post,
                "class" => "col-6 col-lg-3 mb-4 mb-lg-0",
                "cat" => true
            ]); ?>
        <?php endforeach; endif; ?>
    </div>
</section>

<div class="container">
    <div class="row">
        <div class="col4">

        </div>
    </div>
</div>
