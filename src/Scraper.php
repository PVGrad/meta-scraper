<?php

namespace Tomaj\Scraper;

use GuzzleHttp\Client;

class Scraper
{
    /**
     * @throws \GuzzleHttp\Exception\RequestException
     */
    public function parseUrl($url)
    {
        $client = new Client();
        $res = $client->get($url);

        return $this->parse($res->getBody());
    }

    public function parse($content)
    {
        $meta = new Meta();

        $matches = [];

        if (!$content) {
            return $meta;
        }

        preg_match('/<title>(.+)<\/title\>/Uis', $content, $matches);
        if ($matches) {
            $meta->setTitle(htmlspecialchars_decode($matches[1]));
        }

        preg_match('/<meta\s*name=\"description\"\s*content=\"(.+)\"\s*[\/]*\>/Uis', $content, $matches);
        if ($matches) {
            $meta->setDescription(htmlspecialchars_decode($matches[1]));
        }

        preg_match('/<meta\s*name=\"keywords\"\s*content=\"(.+)\"\s*[\/]*\>/Uis', $content, $matches);
        if ($matches) {
            $meta->setKeywords(htmlspecialchars_decode($matches[1]));
        }

        preg_match('/<meta\s*name=\"author\"\s*content=\"(.+)\"\s*[\/]*\>/Uis', $content, $matches);
        if ($matches) {
            $meta->setAuthor(htmlspecialchars_decode($matches[1]));
        }

        // todo - optimalize to one preg_match for all og:*
        preg_match('/<meta\s*property=\"og:title\"\s*content=\"(.+)\"\s*[\/]*\>/Uis', $content, $matches);
        if ($matches) {
            $meta->setOgTitle(htmlspecialchars_decode($matches[1]));
        }

        preg_match('/<meta\s*property=\"og:description\"\s*content=\"(.+)\"\s*[\/]*\>/Uis', $content, $matches);
        if ($matches) {
            $meta->setOgDescription(htmlspecialchars_decode($matches[1]));
        }

        preg_match('/<meta\s*property=\"og:type\"\s*content=\"(.+)\"\s*[\/]*\>/Uis', $content, $matches);
        if ($matches) {
            $meta->setOgType(htmlspecialchars_decode($matches[1]));
        }

        preg_match('/<meta\s*property=\"og:url\"\s*content=\"(.+)\"\s*[\/]*\>/Uis', $content, $matches);
        if ($matches) {
            $meta->setOgUrl(htmlspecialchars_decode($matches[1]));
        }

        preg_match('/<meta\s*property=\"og:site_name\"\s*content=\"(.+)\"\s*[\/]*\>/Uis', $content, $matches);
        if ($matches) {
            $meta->setOgSiteName(htmlspecialchars_decode($matches[1]));
        }

        preg_match('/<meta\s*property=\"og:image\"\s*content=\"(.+)\"\s*[\/]*\>/Uis', $content, $matches);
        if ($matches) {
            $meta->setOgImage(htmlspecialchars_decode($matches[1]));
        }

        return $meta;
    }
}
