<?php
namespace Hansputera\SeCrawler\Interfaces;

class SingleImageItemInterface
{
    public string $title;
    public string $size;
    public string $image;
    public string $small;
    public string $copy;

    public function __construct($data)
    {
        $this->title = $data['title'];
        $this->small = $data['small'];
        $this->size  = $data['size'];
        $this->image = $data['image'];
        $this->copy  = $data['copy'];
    }
}