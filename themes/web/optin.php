<?php $v->layout("_theme"); ?>

<article class="optin_page">
    <div class="container content">
        <div class="row">
            <div class="col-12 col-lg-8 content mx-auto my-xl-3">
                <div class="optin_page_content text-center">
                    <img class="rounded-lg mb-3" alt="<?= $data->title; ?>" title="<?= $data->title; ?>"
                         src="<?= $data->image; ?>"/>
                    <h1 class="mb-3"><?= $data->title; ?></h1>
                    <p><?= $data->desc; ?></p>
                    <?php if (!empty($data->link)): ?>
                        <a class="mt-5 btn btn_theme_blue rounded-pill"
                           href="<?= $data->link; ?>" title="<?= $data->linkTitle; ?>"><?= $data->linkTitle; ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</article>
