## introduction
This project/library is focused to my client. And, the project is about to crawling/scraping search engines (e.g. google, yandex, bing,and yahoo) data.

## usage
1. the first, you need to load the 'vendor/autoload.php' into your main file.
2. code it
```php
use Hansputera\SeCrawler\Engines\GoogleEngine;

$google =   new GoogleEngine();
$images =   $google->search_image('SMAN 3 Palu');

print_r($images); // Array ( ... )
/*
    If the results is empty, it would return an empty array: Array()

    If the results isn't empty:
        [14] => Hansputera\SeCrawler\Interfaces\SingleImageItemInterface Object
        (
            [title] => SMAN 3 Palu (@smantipalu) / Twitter
            [size] => 400px x 400px
            [image] => data:image/gif;base64,R0lGODlhAQABAIAAAP///////yH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==
            [small] => data:image/gif;base64,R0lGODlhAQABAIAAAP///////yH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==
            [copy] => twitter.com
        )

    [15] => Hansputera\SeCrawler\Interfaces\SingleImageItemInterface Object
        (
            [title] => SMA NEGERI 3 PALU (@sman3palu.official) • Instagram photos and videos
            [size] => 1080px x 1080px
            [image] => data:image/gif;base64,R0lGODlhAQABAIAAAP///////yH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==
            [small] => data:image/gif;base64,R0lGODlhAQABAIAAAP///////yH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==
            [copy] => www.instagram.com
        )

    [16] => Hansputera\SeCrawler\Interfaces\SingleImageItemInterface Object
        (
            [title] => SMA Negeri 3 Palu - 3 tips from 51 visitors
            [size] => 600px x 600px
            [image] => data:image/gif;base64,R0lGODlhAQABAIAAAP///////yH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==
            [small] => data:image/gif;base64,R0lGODlhAQABAIAAAP///////yH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==
            [copy] => foursquare.com
        )

    [17] => Hansputera\SeCrawler\Interfaces\SingleImageItemInterface Object
        (
            [title] => Siswi Cantik di Palu Ini Tak Setuju Ujian Akhir Sekolah Berbasis Komputer,  Begini Alasannya - Tribunpalu.com
            [size] => 700px x 393px
            [image] => data:image/gif;base64,R0lGODlhAQABAIAAAP///////yH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==
            [small] => data:image/gif;base64,R0lGODlhAQABAIAAAP///////yH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==
            [copy] => palu.tribunnews.com
        )
*/
```

## License
(c) MIT 2023 Hanif Dwy Putra S
