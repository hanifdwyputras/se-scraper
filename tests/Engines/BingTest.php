<?php
declare(strict_types=1);

use Hansputera\SeCrawler\Engines\BingEngine;
use PHPUnit\Framework\TestCase;

final class BingTest extends TestCase
{
    public function testSearchImage(): void
    {
        $bing       =   new BingEngine();
        $results    =   $bing->search_image('sman 3 palu');

        $this->assertIsArray($results);
    }
}