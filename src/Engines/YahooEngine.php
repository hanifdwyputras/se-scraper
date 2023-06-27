<?php
namespace Hansputera\SeCrawler\Engines;

use DOMNode;
use DOMWrap\Document;
use Hansputera\SeCrawler\Interfaces\SingleImageItemInterface;

class YahooEngine extends AbstractEngine
{
    public function __construct()
    {
        parent::__construct('https://search.yahoo.com');
    }

    public function search_image(string $query, bool $asArray = false)
    {
        $headers    =   $this->generateHeaders();
        $queries    =   $this->build_query($query);

        $client     =   new \GuzzleHttp\Client([
            'base_uri'  =>  'https://images.search.yahoo.com',
            'timeout'   =>  2,
        ]);

        $response = $client->get('/search/images', [
            'query'     =>  $queries,
            'headers'   =>  $headers,
        ]);

        if ($response->getStatusCode() !== 200)
        {
            return [];
        }

        return $this->dom_parser($response->getBody()->getContents(), $asArray);
    }

    protected function dom_parser(string $html, bool $asArray = false): mixed
    {
        $json   =   json_decode($html, true);
        $dom    =   new Document();
        $dom->html($json['html']);

        $nodes  =   $dom->find('li.ld');
        if ($nodes->count() < 1)
        {
            return [];
        }

        $data   =   [];
        $nodes->each(function(DOMNode $node) use (&$data, $asArray) {
            $json   = $node->attributes->item(1)->nodeValue;
            $json   = json_decode($json, true);

            if ($json === null) {
                return;
            }

            $item = [
                'title' =>  $json['alt'],
                'image' =>  $json['iurl'],
                'small' =>  $json['ith'],
                'size'  =>  sprintf(
                    "%dpx x %dpx",
                    $json['w'],
                    $json['h'],
                ),
                'copy'  =>  $json['a'],
            ];

            array_push($data, $asArray ? $item : new SingleImageItemInterface($item));
        });

        return $data;
    }

    protected function build_query(string $query, array $options = []): array
    {
        return [
            'ei'    =>  'UTF-8',
            'fr'    =>  'sfp',
            'save'  =>  '1',
            'p'     =>  urlencode($query),
            'nost'  => '1',
            'fr2'   => 'p%3As%2Cv%3Ai%2Cm%3Asb-top',
            'o'     =>  'js',
        ];
    }
}