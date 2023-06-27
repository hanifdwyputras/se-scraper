<?php
namespace Hansputera\SeCrawler\Engines;

use DOMNode;
use DOMWrap\Document;
use Hansputera\SeCrawler\Interfaces\SingleImageItemInterface;

class BingEngine extends AbstractEngine
{
    public function __construct()
    {
        parent::__construct('https://www.bing.com');
    }

    public function search_image(string $query, bool $asArray = false)
    {
        $headers    =   $this->generateHeaders();
        $queries    =   $this->build_query($query);

        $response   =   $this->client->get('/images/search', [
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
        $dom =  new Document();
        $dom->html($html);

        $nodes  =   $dom->find('div.imgpt');
        if ($nodes->count() < 1)
        {
            return [];
        }

        $data   =   [];
        $nodes->each(function(DOMNode $node) use (&$data, $asArray) {
            $json   =   $node->firstChild->attributes->getNamedItem('m')->nodeValue;
            $json   =   json_decode($json, true);


            $nums   =   [0, 0];
            $lastElement    =   $node->lastChild->firstChild->textContent;
            preg_match('/([0-9]+)/', $lastElement, $nums);

            $item = [
                'title'     =>  $json['t'],
                'small'     =>  $json['turl'],
                'image'     =>  $json['murl'],
                'copy'      =>  parse_url($json['purl'], PHP_URL_HOST),
                'size'      =>  sprintf("%dpx x %dpx", $nums[0], $nums[1]),
            ];

            array_push($data, $asArray ? $item : new SingleImageItemInterface($item));
        });

        return $data;
    }

    protected function build_query(string $query, array $options = []): array
    {
        return [
            'form'  =>  'IBASEP',
            'count' =>  '2',
            'first' =>  '1',
            'q'     =>  urlencode($query),
        ];
    }
}