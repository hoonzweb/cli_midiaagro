<?php $v->layout("_theme"); ?>

<article class="post_page bg-white">
    <header class="post_page_header">
        <div class="post_page_hero">
            <span><?= mb_strtoupper($post->category()->title); ?></span>
            <h1><?= $post->title; ?></h1>
            <div class="post_page_meta">
                <div class="author">
                    <div><img alt="<?= "{$post->author()->first_name} {$post->author()->last_name}"; ?>"
                              title="<?= "{$post->author()->first_name} {$post->author()->last_name}"; ?>"
                              src="<?= image($post->author()->photo, 200); ?>"/></div>
                    <div class="name">
                        Publicado por <b><?= "{$post->author()->first_name} {$post->author()->last_name}"; ?></b>
                        <br>
                        em <?= date_fmt($post->post_at, "d/m/Y \à\s H\hi"); ?>
                    </div>
                </div>
            </div>
            <img class="post_page_cover" alt="<?= $post->title; ?>" title="<?= $post->title; ?>"
                 src="<?= image($post->cover, 1280, 720); ?>"/>
        </div>
    </header>

    <div class="post_page_content">
        <div class="htmlchars">
            <h2><?= $post->subtitle; ?></h2>
            <?= html_entity_decode($post->content); ?>
        </div>

        <aside class="social_share">
            <h3 class="social_share_title"><i class="icon-heart" style="color: crimson;"></i>COMPARTILHE:
            </h3>
            <div class="social_share_medias">
                <!--facebook-->
                <div class="fb-share-button" data-href="<?= url("/blog/{$post->uri}"); ?>"
                     data-layout="button_count"
                     data-size="large"
                     data-mobile-iframe="true">
                    <a target="_blank"
                       href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(url("/blog/{$post->uri}")); ?>"
                       class="fb-xfbml-parse-ignore">Compartilhar</a>
                </div>

                <!--twitter-->
                <a href="https://twitter.com/share?ref_src=site" class="twitter-share-button" data-size="large"
                   data-text="<?= $post->title; ?>" data-url="<?= url("/blog/{$post->uri}"); ?>"
                   data-via="<?= str_replace("@", "", CONF_SOCIAL_TWITTER_CREATOR); ?>"
                   data-show-count="true">Tweet</a>
            </div>
        </aside>
    </div>

    <?php if (!empty($related)): ?>
        <div class="container my-4 my-xl-5">
            <div class="post_page_related content">
                <section>
                    <header class="post_page_related_header">
                        <h4>Veja também:</h4>
                        <p>Confira aqui alguns artigos relacionados e obtenha mais dicas de
                            <b><?= mb_strtolower($post->category()->title); ?></b>.</p>
                    </header>

                    <div class="container">
                        <div class="row content">
                            <?php foreach ($related as $post): ?>
                                <?php $v->insert("blog-list",
                                    ["post" => $post, "class" => "col-12 mb-4 col-md-4 mb-md-0"]); ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    <?php endif; ?>

    <div class="post_comment">
        <section class="mb-4">
            <header class="text-center mb-4 ">
                <h4 class="post_comment_title">Deixe seu comentário:</h4>
            </header>

            <div class="fb-comments" data-href="<?= url("/blog/{$post->uri}"); ?>" data-numposts="5"
                 data-width="100%"></div>
    </section>
    </div>
</article>