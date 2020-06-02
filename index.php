<?php
ob_start();

require __DIR__ . "/vendor/autoload.php";

/**
 * BOOTSTRAP
 */

use CoffeeCode\Router\Router;
use Source\Core\Session;

$session = new Session();
$route = new Router(url(), ":");
$route->namespace("Source\App");

/**
 * WEB ROUTES
 */
$route->group(null);
$route->get("/", "Web:home");
$route->get("/{uri}", "Web:blogPost");
$route->post("/buscar", "Web:blogSearch");
$route->get("/buscar", "Web:blogSearch");
$route->get("/em/{category}", "Web:blogCategory");
$route->get("/em/{category}/{page}", "Web:blogCategory");
$route->get("/fale-conosco", "Web:contact");
$route->get("/fale-conosco/{subject}", "Web:contact");
$route->get("/sobre", "Web:about");

//newsletter
$route->post("/newsletter-register", "Web:newsletterRegister");

//optin
$route->group(null);
$route->get("/confirma", "Web:confirm");
$route->get("/obrigado", "Web:success");

//services
$route->group(null);
$route->get("/termos", "Web:terms");
$route->post("/quero-minha-consultoria", "Web:consultancy");

/**
 * ADMIN ROUTES
 */
$route->namespace("Source\App\Admin");
$route->group("/admin");

//login
$route->get("/", "Login:root");
$route->get("/login", "Login:login");
$route->post("/login", "Login:login");

//dash
$route->get("/dash", "Dash:dash");
$route->get("/dash/home", "Dash:home");
$route->post("/dash/home", "Dash:home");
$route->get("/logoff", "Dash:logoff");

//blog
$route->get("/blog/home", "Blog:home");
$route->post("/blog/home", "Blog:home");
$route->get("/blog/home/{search}/{page}", "Blog:home");
$route->get("/blog/post", "Blog:post");
$route->post("/blog/post", "Blog:post");
$route->get("/blog/post/{post_id}", "Blog:post");
$route->post("/blog/post/{post_id}", "Blog:post");
$route->get("/blog/categories", "Blog:categories");
$route->get("/blog/categories/{page}", "Blog:categories");
$route->get("/blog/category", "Blog:category");
$route->post("/blog/category", "Blog:category");
$route->get("/blog/category/{category_id}", "Blog:category");
$route->post("/blog/category/{category_id}", "Blog:category");

//faqs
$route->get("/faq/home", "Faq:home");
$route->get("/faq/home/{page}", "Faq:home");
$route->get("/faq/channel", "Faq:channel");
$route->post("/faq/channel", "Faq:channel");
$route->get("/faq/channel/{channel_id}", "Faq:channel");
$route->post("/faq/channel/{channel_id}", "Faq:channel");
$route->get("/faq/question/{channel_id}", "Faq:question");
$route->post("/faq/question/{channel_id}", "Faq:question");
$route->get("/faq/question/{channel_id}/{question_id}", "Faq:question");
$route->post("/faq/question/{channel_id}/{question_id}", "Faq:question");

//users
$route->get("/users/home", "Users:home");
$route->post("/users/home", "Users:home");
$route->get("/users/home/{search}/{page}", "Users:home");
$route->get("/users/user", "Users:user");
$route->post("/users/user", "Users:user");
$route->get("/users/user/{user_id}", "Users:user");
$route->post("/users/user/{user_id}", "Users:user");

//notification center
$route->post("/notifications/count", "Notifications:count");
$route->post("/notifications/list", "Notifications:list");

//END ADMIN
$route->namespace("Source\App");

/**
 * PAY ROUTES
 */
$route->group("/pay");
$route->post("/create", "Pay:create");
$route->post("/update", "Pay:update");

/**
 * ERROR ROUTES
 */
$route->group("/ops");
$route->get("/{errcode}", "Web:error");

/**
 * ROUTE
 */
$route->dispatch();

/**
 * ERROR REDIRECT
 */
if ($route->error()) {
    $route->redirect("/ops/{$route->error()}");
}

ob_end_flush();