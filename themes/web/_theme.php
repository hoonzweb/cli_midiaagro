<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php
    if (CONF_SITE_GTM):
        ?>
        <!-- Google Tag Manager -->
        <script>(function (w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start':
                        new Date().getTime(), event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', 'GTM-<?= CONF_SITE_GTM ?>');</script>
        <!-- End Google Tag Manager -->
    <?php
    endif;
    ?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <?= $head ?>

    <link href="<?= theme("/assets/images/favicon.png"); ?>" rel="icon" type="image/png">
    <link rel="stylesheet" href="<?= theme("/assets/style.css"); ?>">

    <script data-ad-client="ca-pub-6292645270165388" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-<?= CONF_SITE_GTM ?>"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <p class="ajax_load_box_title">Aguarde, carregando...</p>
    </div>
</div>

<?= $v->insert("_header"); ?>

<main class="py-3 pb-lg-4 pb-xl-5">
    <?php
    if (empty($route) || mb_strpos($route, "/em") === 0):
        ?>
        <!-- ANÚNCIO -->
        <div class="container mb-3 mb-lg-4 j_ads">
            <a href="#" title="Abapa - 20 Anos">
                <img src="<?= theme("/assets/images/abapa-coronavirus-ads-1108.jpg") ?>" alt="Abapa - 20 Anos"
                     class="d-block">
            </a>
        </div>
    <?php endif; ?>

    <?= $v->section("content"); ?>

    <div class="container">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- Horizontal 1108x100 -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:1108px;height:100px"
             data-ad-client="ca-pub-6292645270165388"
             data-ad-slot="1741401127"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
</main>

<?= $v->insert("_footer"); ?>

<script src="<?= theme("/assets/scripts.js") ?>"></script>
<?= $v->section("scripts"); ?>
</body>
</html>