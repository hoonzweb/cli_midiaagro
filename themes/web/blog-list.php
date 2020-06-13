<div class="<?= $class; ?>">
    <article>
        <?php if(empty($video)): ?>
        <a title="<?= $post->title; ?>" href="<?= url("/{$post->uri}"); ?>">
            <div class="post_cover">
                <img src="<?= image($post->cover, 800, 450); ?>" alt="<?= $post->title; ?>">
            </div>
        </a>
        <?php else: ?>
            <div class="embed mb-3">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $post->video ?>" frameborder="0"
                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
            </div>
        <?php endif; ?>
        <header>
            <?php if (!empty($cat)): ?>
                <a class="post_category" title="Artigos em <?= $post->category()->title; ?>"
                   href="<?= url("/em/{$post->category()->uri}"); ?>">
                    <?= mb_strtoupper($post->category()->title); ?></a>
            <?php endif; ?>
            <a href="<?= url("/{$post->uri}"); ?>" title="<?= $post->title; ?>">
                <h3 class="post_title <?= (!empty($tsize) ? $tsize : '') ?>"><?= str_limit_chars($post->title, 65, " [leia mais]"); ?></h3></a>
        </header>
        <?php if (!empty($p)): ?>
            <p class="mt-2 <?= (!empty($psize) ? $psize : '') ?>"><?= str_limit_chars($post->subtitle, "150"); ?></p>
        <?php endif; ?>
    </article>
</div>