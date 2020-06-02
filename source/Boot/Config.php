<?php
/**
 * DATABASE
 */
if (strpos($_SERVER['HTTP_HOST'], "localhost")) {
    define("DATA_LAYER_CONFIG", [
        "driver" => "mysql",
        "host" => "localhost",
        "port" => "3306",
        "dbname" => "midiaagro",
        "username" => "root",
        "passwd" => "",
        "options" => [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_CASE => PDO::CASE_NATURAL
        ]
    ]);
}else{
    define("DATA_LAYER_CONFIG", [
    "driver" => "mysql",
    "host" => "localhost",
    "port" => "3306",
    "dbname" => "midiaagr_o",
    "username" => "midiaagr_o",
    "passwd" => "4V*X*A9LgXnkr0Rj",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);
}


/**
 * PROJECT URLs
 */
define("CONF_URL_BASE", "https://www.midiaagro.com.br");
define("CONF_URL_TEST", "https://www.localhost/midiaagro");

/**
 * SITE
 */
define("CONF_SITE_NAME", "Midiaagro");
define("CONF_SITE_TITLE", "Portal do Agronegócio de Luís Eduardo Magalhães.");
define("CONF_SITE_DESC", "Encontre notícias em primeira mão do agronegócio de Luis Eduardo Magalhães e Mundo.");
define("CONF_SITE_LANG", "pt_BR");
define("CONF_SITE_DOMAIN", "midiaagro.com.br");
define("CONF_SITE_ADDR_STREET", "");
define("CONF_SITE_ADDR_NUMBER", "");
define("CONF_SITE_ADDR_COMPLEMENT", "");
define("CONF_SITE_ADDR_CITY", "Luís Eduardo Magalhães");
define("CONF_SITE_ADDR_STATE", "BA");
define("CONF_SITE_ADDR_ZIPCODE", "");
define("CONF_SITE_GTM", "PKDMRV2"); //GTM-XXXXXXX (GOOGLE TAG MANAGER)

/**
 * SOCIAL
 */
define("CONF_SOCIAL_TWITTER_CREATOR", "@oitallolima");
define("CONF_SOCIAL_TWITTER_PUBLISHER", "@oitallolima");
define("CONF_SOCIAL_FACEBOOK_APP", "250029786355942");
define("CONF_SOCIAL_FACEBOOK_PAGE", "midiaagro");
define("CONF_SOCIAL_FACEBOOK_AUTHOR", "agenciahoonz");
define("CONF_SOCIAL_INSTAGRAM_PAGE", "midiaagro");
define("CONF_SOCIAL_YOUTUBE_PAGE", "hoonz");

/**
 * DATES
 */
define("CONF_DATE_BR", "d/m/Y H:i:s");
define("CONF_DATE_APP", "Y-m-d H:i:s");

/**
 * PASSWORD
 */
define("CONF_PASSWD_MIN_LEN", 8);
define("CONF_PASSWD_MAX_LEN", 40);
define("CONF_PASSWD_ALGO", PASSWORD_DEFAULT);
define("CONF_PASSWD_OPTION", ["cost" => 10]);

/**
 * VIEW
 */
define("CONF_VIEW_PATH", __DIR__ . "/../../shared/views");
define("CONF_VIEW_EXT", "php");
define("CONF_VIEW_ADMIN", "admin");
define("CONF_VIEW_APP", "");
define("CONF_VIEW_THEME", "web");

/**
 * UPLOAD
 */
define("CONF_UPLOAD_DIR", "storage");
define("CONF_UPLOAD_IMAGE_DIR", "images");
define("CONF_UPLOAD_FILE_DIR", "files");
define("CONF_UPLOAD_MEDIA_DIR", "medias");

/**
 * IMAGES
 */
define("CONF_IMAGE_CACHE", CONF_UPLOAD_DIR . "/" . CONF_UPLOAD_IMAGE_DIR . "/cache");
define("CONF_IMAGE_SIZE", 2000);
define("CONF_IMAGE_QUALITY", ["jpg" => 75, "png" => 5]);

/**
 * MAIL
 */
define("CONF_MAIL_HOST", "smtp.sendgrid.net");
define("CONF_MAIL_PORT", "587");
define("CONF_MAIL_USER", "apikey");
define("CONF_MAIL_PASS", "SG.YCtgj0PMT0yhwCbI2Ie5Ew.gc7IJnLsMgVytklzNDjMDtkTwuhwruIcjKjL3uND5Mw");
define("CONF_MAIL_SENDER", ["name" => "Agência Hoonz", "address" => "naoresponda@hoonz.com.br"]);
define("CONF_MAIL_SUPPORT", "falecom@hoonz.com.br");
define("CONF_MAIL_OPTION_LANG", "br");
define("CONF_MAIL_OPTION_HTML", true);
define("CONF_MAIL_OPTION_AUTH", true);
define("CONF_MAIL_OPTION_SECURE", "tls");
define("CONF_MAIL_OPTION_CHARSET", "utf-8");