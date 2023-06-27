<?php
declare(strict_types=1);

use Hansputera\SeCrawler\Engines\GoogleEngine;
use PHPUnit\Framework\TestCase;

final class GoogleTest extends TestCase
{
    public function testImageSearch(): void
    {
        $google = new GoogleEngine();

        $data = $google->search_image('sman 3 palu');
        // print_r($data);

        $this->assertIsArray($data);
    }
}
