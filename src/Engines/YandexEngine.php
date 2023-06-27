<?php
namespace Hansputera\SeCrawler\Engines;

use DOMNode;
use DOMWrap\Document;
use Hansputera\SeCrawler\Interfaces\SingleImageItemInterface;

class YandexEngine extends AbstractEngine
{
    public function __construct()
    {
        parent::__construct('https://yandex.com');
    }

    public function search_image(string $query)
    {
        $headers =  $this->generateHeaders();
        $queries =  $this->build_query($query);

        $response = $this->client->get('/images/search', [
            'query'     =>  $queries,
            'headers'   =>  $headers,
        ]);
        if ($response->getStatusCode() !== 200)
        {
            return [];
        }

        return $this->dom_parser($response->getBody()->getContents());
    }

    protected function dom_parser(string $html): mixed
    {
        $dom    = new Document();
        $dom->html($html);

        $nodes  = $dom->find('[data-bem]');
        if ($nodes->count() < 1)
        {
            return [];
        }

        $data   =   [];
        $nodes->each(function(DOMNode $node) use (&$data) {
            $json = $node->attributes->getNamedItem('data-bem')->nodeValue;
            $json = json_decode($json, true);

            array_push($data, new SingleImageItemInterface([
                'title' =>  $json['serp-item']['snippet']['title'],
                'image' =>  $json['serp-item']['img_href'],
                'small' =>  $json['serp-item']['thumb']['url'],
                'size'  =>  sprintf(
                    "%dpx x %dpx",
                    $json['serp-item']['preview'][0]['width'],
                    $json['serp-item']['preview'][0]['height'],
                ),
                'copy'  =>  parse_url($json['serp-item']['img_href'], PHP_URL_HOST),
            ]));
        });

        return $data;
    }

    protected function build_query(string $query, array $options = []): array
    {
        return [
            'text'  =>  urlencode($query),
        ];
    }
}