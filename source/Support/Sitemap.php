<?php

namespace Source\Support;

use Source\Models\Category;
use Source\Models\Post;

/**
 * Class sitemap
 * Classe responável por gerar sitemaps e RSS feeds
 *
 * @author Itallo Lima <falecom@hoonz.com.br>
 * @package Source\Support
 */
class Sitemap
{
    //sitemap
    private $sitemap;
    private $sitemapXml;
    private $sitemapGz;
    private $sitemapPing;

    //RSS
    private $RSS;
    private $RSSXml;

    public function exeSitemap($Ping = true): sitemap
    {
        $this->sitemapUpdate();
        if ($Ping != false):
            $this->sitemapPing();
        endif;
        return $this;
    }

    public function exeRSS(): sitemap
    {
        $this->RSSUpdate();
        return $this;
    }

    private function sitemapUpdate()
    {
        $this->sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\r\n";
        $this->sitemap .= '<?xml-stylesheet type="text/xsl" href="sitemap.xsl"?>' . "\r\n";
        $this->sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\r\n";

        //HOME
        $this->sitemap .= '<url>' . "\r\n";
        $this->sitemap .= '<loc>' . url() . '</loc>' . "\r\n";
        $this->sitemap .= '<lastmod>' . date('Y-m-d\TH:i:sP') . '</lastmod>' . "\r\n";
        $this->sitemap .= '<changefreq>daily</changefreq>' . "\r\n";
        $this->sitemap .= '<priority>1.0</priority >' . "\r\n";
        $this->sitemap .= '</url>' . "\r\n";

        //CATEGORIES
        $cats = (new Category())->find()->order("title ASC")->fetch(true);
        if ($cats):
            foreach ($cats as $cat):
                $this->sitemap .= '<url>' . "\r\n";
                $this->sitemap .= '<loc>' . url("/em/{$cat->uri}") . '</loc>' . "\r\n";
                $this->sitemap .= '<lastmod>' . date('Y-m-d\TH:i:sP', strtotime($cat->updated_at)) . '</lastmod>' . "\r\n";
                $this->sitemap .= '<changefreq>monthly</changefreq>' . "\r\n";
                $this->sitemap .= '<priority>0.7</priority >' . "\r\n";
                $this->sitemap .= '</url>' . "\r\n";
            endforeach;
        endif;

        //POSTS
        $posts = (new Post())->findPost()->order("post_at DESC")->fetch(true);
        if ($posts):
            foreach ($posts as $post):
                $this->sitemap .= '<url>' . "\r\n";
                $this->sitemap .= '<loc>' . url("/{$post->uri}") . '</loc>' . "\r\n";
                $this->sitemap .= '<lastmod>' . date('Y-m-d\TH:i:sP', strtotime($post->updated_at)) . '</lastmod>' . "\r\n";
                $this->sitemap .= '<changefreq>weekly</changefreq>' . "\r\n";
                $this->sitemap .= '<priority>0.9</priority >' . "\r\n";
                $this->sitemap .= '</url>' . "\r\n";
            endforeach;
        endif;

        //CLOSE
        $this->sitemap .= '</urlset>';

        //CRIA O XML
        $this->sitemapXml = fopen(dirname(__DIR__, 2)."/sitemap.xml", "w+");
        fwrite($this->sitemapXml, $this->sitemap);
        fclose($this->sitemapXml);

        //CRIA O GZ
        $this->sitemapGz = gzopen(dirname(__DIR__, 2)."/sitemap.xml.gz", 'w9');
        gzwrite($this->sitemapGz, $this->sitemap);
        gzclose($this->sitemapGz);
    }

    private function sitemapPing()
    {
        $this->sitemapPing = [];
        $this->sitemapPing['g'] = 'https://www.google.com/webmasters/tools/ping?sitemap=' . urlencode(url("/sitemap.xml"));
        $this->sitemapPing['b'] = 'https://www.bing.com/webmaster/ping.aspx?sitemap=' . urlencode(url("/sitemap.xml"));

        foreach ($this->sitemapPing as $url):
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_exec($ch);
            curl_close($ch);
        endforeach;
    }

    private function RSSUpdate()
    {
        $this->RSS = '<?xml version="1.0" encoding="UTF-8" ?>' . "\r\n";
        $this->RSS .= '<rss version="2.0">' . "\r\n";
        $this->RSS .= '<channel>' . "\r\n";

        $this->RSS .= '<title>' . CONF_SITE_TITLE . '</title>' . "\r\n";
        $this->RSS .= '<link>' . url() . '</link>' . "\r\n";
        $this->RSS .= '<description>' . CONF_SITE_DESC . '</description>' . "\r\n";
        $this->RSS .= '<language>pt-br</language>' . "\r\n";

        //POSTS
        $posts = (new Post())->findPost()->order("post_at DESC")->fetch(true);
        if ($posts):
            foreach ($posts as $post):
                //FEED
                $this->RSS .= '<item>' . "\r\n";
                $this->RSS .= '<title>' . $post->title . '</title>' . "\r\n";
                $this->RSS .= '<link>' . url("/{$post->uri}") . '</link>' . "\r\n";
                $this->RSS .= '<pubDate>' . date('D, d M Y H:i:s O', strtotime($post->post_at)) . '</pubDate>' . "\r\n";
                $this->RSS .= '<description>' . str_replace('&', 'e', $post->subtitle) . '</description>' . "\r\n";
                $this->RSS .= '<enclosure type="image/*" url="'.url("/storage/{$post->cover}").'" />' . "\r\n";
                $this->RSS .= '</item>' . "\r\n";
            endforeach;
        endif;

        $this->RSS .= '</channel>' . "\r\n";
        $this->RSS .= '</rss>' . "\r\n";

        //CRIA O XML
        $this->RSSXml = fopen(dirname(__DIR__, 2)."/rss.xml", "w+");
        fwrite($this->RSSXml, $this->RSS);
        fclose($this->RSSXml);
    }

}