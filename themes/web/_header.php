<header class="w-100 main_header <?= (empty($route)) ? 'main_header_home' : '' ?>">
    <div class="container">
        <div class="row">
            <div class="col-8 col-md-4">
                <h1 class="fontzero"><?= CONF_SITE_NAME ?></h1>
                <a href="<?= url(); ?>" title="<?= CONF_SITE_NAME ?>">
                    <img class="main_header_logo" src="<?= theme("/assets/images/midiaagro.png"); ?>" alt="<?= CONF_SITE_NAME ?>">
                </a>
            </div>

            <div class="col-md-6 d-none d-md-flex align-items-center d-xl-none">
                <?= $v->insert("_form-search", ["class" => "d-flex w-100 d-xl-none"]); ?>
            </div>

            <nav class="main_header_menu j_menu_mobile col-xl-8">
                <?= $v->insert("_form-search", ["class" => "d-flex mb-4 d-md-none", "placeholder" => "Buscar:"]); ?>

                <ul class="main_header_menu_ul">
                    <li><a href="<?= url() ?>" title="início">início</a></li>
                    <li><a href="<?= url("/sobre") ?>" title="sobre nós">sobre nós</a></li>
                    <li><a href="#" title="editorias">editorias<i class="ml-2 icon-angle-down icon-notext"></i></a>
                        <ul class="main_header_menu_li_ul">
                            <?php if($categories): foreach ($categories as $cat): ?>
                            <li><a href="<?= url("/em/{$cat->uri}") ?>" title="<?= $cat->title ?>"><?= $cat->title ?></a></li>
                            <?php endforeach; endif; ?>
                        </ul>
                    </li>
                    <li><a href="<?= url("/em/empregos") ?>" title="empregos">empregos</a></li>
                    <li><a href="<?= url("/em/eventos") ?>" title="eventos">eventos</a></li>
                    <li><a href="<?= url("/em/entrevistas") ?>" title="entrevistas">entrevistas</a></li>
                    <li class="d-none d-xl-inline-block">
                        <a href="#" class="icon-search icon-notext j_toggle_search"></a>
                    </li>
                </ul>
            </nav>

            <div class="col-4 col-md-2 d-flex align-items-center justify-content-end d-xl-none">
                <a href="#" class="icon-menu icon-notext main_header_toggle_menu j_toggle_menu_mobile"></a>
            </div>
        </div>
    </div>
    <div class="main_header_search j_search">
        <div class="container">
            <?= $v->insert("_form-search", ["class" => "d-flex"]); ?>
        </div>
    </div>
</header>