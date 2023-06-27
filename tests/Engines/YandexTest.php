<?php
declare(strict_types=1);

use Hansputera\SeCrawler\Engines\YandexEngine as EnginesYandexEngine;
use PHPUnit\Framework\TestCase;

final class YandexTest extends TestCase
{
    public function testSearchEngine(): void
    {
        $yandex     =   new EnginesYandexEngine();
        $results    =   $yandex->search_image('sman 3 palu');

        $this->assertIsArray($results);
    }
}