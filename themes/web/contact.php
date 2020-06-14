<?php $v->layout("_theme"); ?>

<article class="container">
    <div class="row">
        <div class="col-12 col-lg-8 content mx-auto my-xl-3">
            <div class="p-4">
                <header class="blog_header">
                    <h1 class="blog_header_title">Fale Conosco</h1>
                    <p class="mb-2 blog_header_desc">Precisa de ajuda? Ou quer tratar de outros assuntos?</p>
                    <span class="blog_header_border"></span>
                </header>

                <form action="<?= url("/fale-conosco/send"); ?>" method="post">
                    <label class="form-group mb-4">
                        <span>Primeiro nome:</span>
                        <input type="text" class="form-control form-control-border" name="first_name">
                    </label>

                    <label class="form-group mb-4">
                        <span>Seu e-mail:</span>
                        <input type="text" class="form-control form-control-border" name="email">
                    </label>

                    <label class="form-group mb-4">
                        <span>Assunto:</span>
                        <input type="text" class="form-control form-control-border" name="subject" value="<?= $subject ?? '' ?>">
                    </label>

                    <label class="form-group mb-4">
                        <span>Mensagem:</span>
                        <textarea class="form-control form-control-border" name="message" rows="10"></textarea>
                    </label>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-lg">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</article>