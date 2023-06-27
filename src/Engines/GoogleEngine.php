<?php
namespace Hansputera\SeCrawler\Engines;

use DOMDocument;
use DOMNode;
use DOMWrap\Document;
use Hansputera\SeCrawler\Interfaces\SingleImageItemInterface;

class GoogleEngine extends AbstractEngine
{
    public function __construct()
    {
        parent::__construct('https://google.com');
    }

    public function search_image(string $query)
    {
        // preparation
        $headers = $this->generateHeaders();
        $queries = $this->build_query($query, [
            'tbm'   =>  'isch',
        ]);

        // actions
        $response = $this->client->get('/search', [
            'query'     => $queries,
            'headers'   =>  $headers,
        ]);

        if ($response->getStatusCode() !== 200)
        {
            return array();
        }

        // parsing
        $data = $this->dom_parser($response->getBody()->getContents());

        return $data;
    }

    protected function dom_parser(string $html): mixed
    {
        $dom = new Document();
        $dom->html($html);

        $nodes = $dom->find('div.isv-r')->filter('[data-ow]');
        if ($nodes->count() < 2)
        {
            return [];
        }

        $data = [];

        $nodes->map(function(DOMNode $node) use (&$data) {
            $dom = new DOMDocument();
            $dom->appendChild($dom->importNode($node, true));

            $currentAttr = $dom->firstChild->attributes;
            $images = $dom->getElementsByTagName('img');

            $copy = $dom->getElementsByTagName('a')->item(0)->attributes->getNamedItem('href')->nodeValue;
            if ($copy)
            {
                $outs = [];
                preg_match_all('/\/imgres\?imgurl=(.+)\&tbnid/', $copy, $outs);

                $copy = $outs[1];
            } else {
                $copy = parse_url($dom->getElementsByTagName('a')->item(1)->attributes->getNamedItem('href')->nodeValue, PHP_URL_HOST);
            }

            array_push($data, new SingleImageItemInterface([
                'title' => $dom->getElementsByTagName('h3')->item(0)->textContent,
                'image' => $images->item(0)->attributes->item(0)->nodeValue,
                'size'  => sprintf("%spx %spx", $currentAttr->getNamedItem('data-ow')->nodeValue, $currentAttr->getNamedItem('data-oh')->nodeValue),
                'small' => $images->item(1)->attributes->item(0)->nodeValue,
                'copy'  => $copy,
            ]));
        });

        return $data;
    }

    protected function build_query(string $query, array $options = []): array
    {
        return array_merge([
            'q' => urlencode($query),
        ], $options);
    }
}