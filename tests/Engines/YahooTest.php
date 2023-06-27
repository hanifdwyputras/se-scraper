<?php
declare(strict_types=1);

use Hansputera\SeCrawler\Engines\YahooEngine;
use PHPUnit\Framework\TestCase;

final class YahooTest extends TestCase
{
    public function testSearchImage(): void
    {
        $yahoo  =   new YahooEngine();
        $data   =   $yahoo->search_image('sman 3 palu');

        $this->assertIsArray($data);
    }
}