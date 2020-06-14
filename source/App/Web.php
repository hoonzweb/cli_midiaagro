<?php

namespace Source\App;

use Source\Core\Controller;
use Source\Core\View;
use Source\Models\Auth;
use Source\Models\Category;
use Source\Models\Newsletter;
use Source\Models\Post;
use Source\Models\Report\Access;
use Source\Models\Report\Online;
use Source\Models\User;
use Source\Support\Email;
use Source\Support\Pager;

/**
 * Web Controller
 * @package Source\App
 */
class Web extends Controller
{
    /**
     * Web constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/");

        $route = filter_input(INPUT_GET, "route", FILTER_SANITIZE_STRIPPED);
        $this->view->addData([
            "route" => $route,
            "categories" => (new Category())
                ->find("uri != 'empregos'
                 AND uri != 'eventos'
                 AND uri != 'entrevistas'
                 ")
                ->fetch(true),
            "moreReadsCat" => (new Post())
                ->findPost()
                ->order("views DESC")
                ->group("category")
                ->limit(8)
                ->fetch(true)
        ]);

        (new Access())->report();
        (new Online())->report();

        /**
         * MAINTENANCE MODE
         */
        $maintenance = 0;
        if ($maintenance && !Auth::user()) {
            redirect("/ops/manutencao");
        }
    }

    /**
     * SITE HOME
     */
    public function home(): void
    {
        $head = $this->seo->render(
            CONF_SITE_NAME . " - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );

        $catId = function ($uri) {
            $getId = (new Category())->findByUri($uri);
            return $getId ? $getId->id : null;
        };

        echo $this->view->render("home", [
            "head" => $head,
            "highlights" => (new Post())
                ->findPost("position = 'highlight'")
                ->order("post_at DESC")
                ->limit(3)
                ->fetch(true),
            "relevants" => (new Post())
                ->findPost("position = 'relevant'")
                ->order("post_at DESC")
                ->limit(4)
                ->fetch(true),
            "tech1" => (new Post())
                ->findPost("category = {$catId("tecnologia")}")
                ->order("post_at DESC")
                ->limit(2)
                ->fetch(true),
            "tech2" => (new Post())
                ->findPost("category = {$catId("tecnologia")}")
                ->order("post_at DESC")
                ->limit(4)
                ->offset(2)
                ->fetch(true),
            "events" => (new Post())
                ->findPost("category = {$catId("eventos")}")
                ->order("post_at DESC")
                ->limit(2)
                ->fetch(true),
            "interview" => (new Post())
                ->findPost("category = {$catId("entrevistas")}")
                ->order("post_at DESC")
                ->limit(3)
                ->fetch(true),
            "camp" => (new Post())
                ->findPost("category = {$catId("sabores-do-campo")}")
                ->order("post_at DESC")
                ->limit(3)
                ->fetch(true),
            "videos" => (new Post())
                ->findPost("category = {$catId("videos")}")
                ->order("post_at DESC")
                ->limit(2)
                ->fetch(true),
            "moreReads" => (new Post())
                ->findPost()
                ->order("views DESC")
                ->limit(4)
                ->fetch(true)
        ]);
    }


    /**
     * SITE BLOG CATEGORY
     * @param array $data
     */
    public function blogCategory(array $data): void
    {
        $categoryUri = filter_var($data["category"], FILTER_SANITIZE_STRIPPED);
        $category = (new Category())->findByUri($categoryUri);

        if (!$category) {
            redirect("/blog");
        }

        $blogCategory = (new Post())->findPost("category = :c", "c={$category->id}");
        $page = (!empty($data['page']) && filter_var($data['page'], FILTER_VALIDATE_INT) >= 1 ? $data['page'] : 1);
        $pager = new Pager(url("/em/{$category->uri}/"));
        $pager->pager($blogCategory->count(), 8, $page);

        $head = $this->seo->render(
            "{$category->title} - " . CONF_SITE_NAME,
            $category->description,
            url("/em/{$category->uri}/{$page}"),
            ($category->cover ? image($category->cover, 1200, 628) : theme("/assets/images/share.jpg"))
        );

        echo $this->view->render("blog", [
            "head" => $head,
            "title" => "{$category->title}",
            "desc" => $category->description,
            "blog" => $blogCategory
                ->limit($pager->limit())
                ->offset($pager->offset())
                ->order("post_at DESC")
                ->fetch(true),
            "paginator" => $pager->render(),
            "category" => $category
        ]);
    }

    /**
     * SITE BLOG SEARCH
     * @param array $data
     */
    public function blogSearch(array $data): void
    {
        if (!empty($data['s'])) {
            $search = str_search($data['s']);
            echo json_encode(["redirect" => url("/buscar?q={$search}&pg=1")]);
            return;
        }

        $search = str_search(filter_input(INPUT_GET, "q", FILTER_SANITIZE_STRIPPED));
        $pg = filter_input(INPUT_GET, "pg", FILTER_VALIDATE_INT);
        $page = ($pg >= 1 ? $pg : 1);

        if ($search == "all" || $search == "BUSCAR POR") {
            redirect("/blog");
        }

        $head = $this->seo->render(
            "Pesquisa por {$search} - " . CONF_SITE_NAME,
            "Confira os resultados de sua pesquisa para {$search}",
            url("/buscar?q={$search}&pg={$page}"),
            theme("/assets/images/share.jpg")
        );

        $blogSearch = (new Post())->findPost("MATCH(title, subtitle) AGAINST(:s)", "s={$search}");
        $categories = (new Category())->find()->fetch(true);

        if (!$blogSearch->count()) {
            echo $this->view->render("blog", [
                "head" => $head,
                "title" => "PESQUISA POR:",
                "search" => $search,
                "categories" => $categories
            ]);
            return;
        }

        $pager = new Pager(url("/buscar?q={$search}&pg="));
        $pager->pager($blogSearch->count(), 9, $page);

        echo $this->view->render("blog", [
            "head" => $head,
            "title" => "PESQUISA POR:",
            "search" => $search,
            "blog" => $blogSearch->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "categories" => $categories,
            "paginator" => $pager->render()
        ]);
    }

    /**
     * SITE BLOG POST
     * @param array $data
     */
    public function blogPost(array $data): void
    {
        $post = (new Post())->findByUri($data['uri']);
        if (!$post) {
            redirect("/ops/404");
        }

        $user = Auth::user();
        if (!$user || $user->level < 5) {
            $post->views += 1;
            $post->save();
        }

        $head = $this->seo->render(
            "{$post->title} - " . CONF_SITE_NAME,
            $post->subtitle,
            url("/{$post->uri}"),
            ($post->cover ? image($post->cover, 1200, 628) : theme("/assets/images/share.jpg"))
        );

        echo $this->view->render("blog-post", [
            "head" => $head,
            "post" => $post,
            "related" => (new Post())
                ->findPost("category = :c AND id != :i", "c={$post->category}&i={$post->id}")
                ->order("rand()")
                ->limit(3)
                ->fetch(true)
        ]);
    }


    /**
     * SITE CONSULTANCY
     * @param array $data
     */
    public function consultancy(array $data): void
    {
        if (!empty($data['csrf'])) {
            if (!csrf_verify($data)) {
                $json['message'] = $this->message->error("Erro ao enviar, favor use o formulário")->render();
                echo json_encode($json);
                return;
            }

            if (empty($data['name']) || $data['name'] == "SEU NOME:") {
                $json['message'] = $this->message->info("Informe o seu nome!")->before("Ooops: ")->render();
                echo json_encode($json);
                return;
            }

            if (empty($data['email']) || $data['email'] == "SEU E-MAIL:" || !is_email($data['email'])) {
                $json['message'] = $this->message->info("Informe um e-mail válido!")->before("Ooops: ")->render();
                echo json_encode($json);
                return;
            }

            if (empty($data['whatsapp']) || $data['whatsapp'] == "WHATSAPP:" || !is_numeric($data['whatsapp'])) {
                $json['message'] = $this->message->info("Informe um número de whatsapp com DDD para contato!")->before("Ooops: ")->render();
                echo json_encode($json);
                return;
            }

            if (empty($data['business']) || $data['business'] == "NOME DA EMPRESA:") {
                $json['message'] = $this->message->info("Informe o nome da empresa!")->before("Ooops: ")->render();
                echo json_encode($json);
                return;
            }

            if (empty($data['employee']) || $data['employee'] == "QTD. DE FUNCIONÁRIOS:" || !is_numeric($data['employee'])) {
                $json['message'] = $this->message->info("Informe a quantidade atual de funcionários!")->before("Ooops: ")->render();
                echo json_encode($json);
                return;
            }

            if (request_limit("webconsultancy", 1, 60 * 5)) {
                $json['message'] = $this->message->error("Aguarde 5 minutos para tentar solicitar novamente.")->render();
                echo json_encode($json);
                return;
            }

            $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);

            $viewMail = new View(dirname(__DIR__, 2) . "/shared/views/email");
            $message = $viewMail->render("mail", [
                "subject" => "Consultoria Gratuita",
                "message" => "<h3>Solicitação de consultoria:</h3>
                              <p><b>Nome:</b> {$data['name']}</p>
                              <p><b>E-mail:</b> {$data['email']}</p>
                              <p><b>Whatsapp:</b> {$data['whatsapp']}</p>
                              <p><b>Nome da empresa:</b> {$data['business']}</p>
                              <p><b>Qtd. de funcionários:</b> {$data['employee']}</p>
                              <p><b>Website</b> {$data['website']}</p>
                              "
            ]);

            $pushMail = (new Email())->bootstrap(
                "Consultoria Gratuita",
                $message,
                "hoonzweb@gmail.com",
                "Hoonz"
            )->queue("{$data['email']}", "{$data['name']}");

            if ($pushMail) {
                $json['message'] = $this->message
                    ->success("Consultoria solicitada! Entraremos em contato o quanto antes! :)")
                    ->render();
                echo json_encode($json);
                return;
            }
        }
    }

    /**
     * SITE NEWSLETTER REGISTER
     * @param null|array $data
     */
    public function newsletterRegister(?array $data): void
    {
        if (request_limit("webnewsletterregister", 2, 60 * 5)) {
            $json['message'] = $this->message->error("Aguarde 5 minutos para tentar solicitar novamente.")->render();
            echo json_encode($json);
            return;
        }

        if (empty($data['name']) || $data['name'] == "SEU NOME:") {
            $json['message'] = $this->message->info("Informe o seu nome!")->before("Ooops: ")->render();
            echo json_encode($json);
            return;
        }

        if (empty($data['email']) || $data['email'] == "SEU E-MAIL:" || !is_email($data['email'])) {
            $json['message'] = $this->message->info("Informe um e-mail válido!")->before("Ooops: ")->render();
            echo json_encode($json);
            return;
        }

        $insertLead = new Newsletter();
        $insertLead->bootstrap($data['name'], $data['email']);
        if (!$insertLead->save()) {
            $json['message'] = $insertLead->message()->render();
            echo json_encode($json);
            return;
        }

        $json['redirect'] = url("/confirma");
        echo json_encode($json);
        return;
    }

    /**
     * SITE OPT-IN CONFIRM
     */
    public function confirm(): void
    {
        $head = $this->seo->render(
            "Confirme Seu Cadastro - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/confirma"),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("optin", [
            "head" => $head,
            "data" => (object)[
                "title" => "Falta pouco! Confirme seu cadastro.",
                "desc" => "Enviamos um link de confirmação para seu e-mail. Acesse e siga as instruções para concluir seu cadastro.",
                "image" => theme("/assets/images/optin-confirm.jpg")
            ]
        ]);
    }

    /**
     * SITE OPT-IN SUCCESS
     * @param array $data
     */
    public function success(): void
    {
        $head = $this->seo->render(
            "Cadastro confirmado! - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/obrigado"),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("optin", [
            "head" => $head,
            "data" => (object)[
                "title" => "Tudo pronto. Você já pode receber nossos conteúdos :)",
                "desc" => "Bem-vindo(a) a nossa lista VIP, você receberá nossas novidades exclusivas diretamente no seu e-mail!",
                "image" => theme("/assets/images/optin-success.jpg"),
                "link" => url("/"),
                "linkTitle" => "Voltar ao Início"
            ]
        ]);
    }


    /**
     * SITE CONTACT
     * @param array $data
     */
    public function contact(array $data): void
    {
        $head = $this->seo->render(
            "Fale Conosco - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/fale-conosco"),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("contact", [
            "head" => $head,
            "subject" => $data['subject'] ?? ''
        ]);
    }

    /**
     * SITE CONTACT SEND
     * @param array $data
     */
    public function contactSend(array $data): void
    {
        if (request_limit("contactsend", 1, 60 * 5)) {
            $json['message'] = $this->message->error("Aguarde 5 minutos para tentar solicitar novamente.")->render();
            echo json_encode($json);
            return;
        }

        if (in_array("", $data)) {
            $json['message'] = $this->message->warning("Existem campos em branco!")->before("Ooops: ")->render();
            echo json_encode($json);
            return;
        }

        if (empty($data['email']) || !is_email($data['email'])) {
            $json['message'] = $this->message->warning("Informe um e-mail válido!")->before("Ooops: ")->render();
            echo json_encode($json);
            return;
        }

        $viewMail = new View(dirname(__DIR__, 2) . "/shared/views/email");
        $message = $viewMail->render("mail", [
            "subject" => "Midiaagro - Fale Conosco",
            "message" => "<h3>Midiaagro - Fale Conosco:</h3>
                              <p><b>Nome:</b> {$data['first_name']}</p>
                              <p><b>E-mail:</b> {$data['email']}</p>
                              <p><b>Assunto:</b> {$data['subject']}</p>
                              <p><b>Mensagem:</b> {$data['message']}</p>                         
                              "
        ]);

        $pushMail = (new Email())->bootstrap(
            "Midiaagro - Fale Conosco",
            $message,
            "contato@midiaagro.com.br",
            "Midiaagro"
        )->queue("{$data['email']}", "{$data['first_name']}");

        if ($pushMail) {
            $json['message'] = $this->message
                ->success("Mensagem enviada!")
                ->render();
            echo json_encode($json);
            return;
        }
    }

    /**
     * SITE ABOUT
     */
    public function about(): void
    {
        $head = $this->seo->render(
            "Sobre nós - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/sobre"),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("about", [
            "head" => $head
        ]);
    }

    /**
     * SITE TERMS
     */
    public function terms(): void
    {
        $head = $this->seo->render(
            CONF_SITE_NAME . " - Termos de uso",
            CONF_SITE_DESC,
            url("/termos"),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("terms", [
            "head" => $head
        ]);
    }

    /**
     * SITE NAV ERROR
     * @param array $data
     */
    public function error(array $data): void
    {
        $error = new \stdClass();

        switch ($data['errcode']) {
            case "problemas":
                $error->code = "OPS";
                $error->title = "Estamos enfrentando problemas!";
                $error->message = "Parece que nosso serviço não está diponível no momento. Já estamos vendo isso mas caso precise, envie um e-mail :)";
                $error->linkTitle = "ENVIAR E-MAIL";
                $error->link = "mailto:" . CONF_MAIL_SUPPORT;
                break;

            case "manutencao":
                $error->code = "OPS";
                $error->title = "Desculpe. Estamos em manutenção!";
                $error->message = "Voltamos logo! Por hora estamos trabalhando para melhorar nosso conteúdo.";
                $error->linkTitle = null;
                $error->link = null;
                break;

            default:
                $error->code = $data['errcode'];
                $error->title = "Ooops. Conteúdo indisponível :/";
                $error->message = "Sentimos muito, mas o conteúdo que você tentou acessar não existe, está indisponível no momento ou foi removido :/";
                $error->linkTitle = "Continue navegando!";
                $error->link = url_back();
                break;
        }

        $head = $this->seo->render(
            "{$error->code} | {$error->title}",
            $error->message,
            url("/ops/{$error->code}"),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("error", [
            "head" => $head,
            "error" => $error
        ]);
    }
}