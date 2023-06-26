<?php
namespace Hansputera\SeCrawler\Engines;

abstract class AbstractEngine
{
    public \GuzzleHttp\Client $client;
    public array $headers;

    public function __construct(string $baseUrl)
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri'      =>  $baseUrl,
            'timeout'       =>  3,
        ]);
        $this->headers = [
            'User-Agent'    =>  'Mozilla/5.0 (X11; Linux x86_64; rv:98.0) Gecko/20100101 Firefox/98.0',
            'Referer'       =>  sprintf('%s/', $baseUrl),
            'Origin'        =>  $baseUrl,
        ];
    }

    public function generateHeaders(array $options = []): array
    {
        return array_merge($this->headers, $options);
    }

    abstract public function build_query(string $query, array $options = []): array;
    abstract public function search_image(string $query);
    abstract protected function dom_parser(string $html): mixed;
}