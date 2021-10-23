<?php

namespace Atakankorkmaz;

use Atakankorkmaz\Exception\PathNotFoundException;
use Atakankorkmaz\Utils\File;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Linguist
{
    public $path = "";

    public $extensions = array();

    public $excludedWords = array();

    public function __construct(string $path)
    {
        $this->checkPathExists($path);
    }

    public function checkPathExists(string $path)
    {
        if (!file_exists($path)) {
            throw new PathNotFoundException("Invalid path!");
        }
        $this->path = $path;
    }

    public function excludeContains(array $words)
    {
        $this->excludedWords = $words;
    }

    public function checkIsExcluded(string $path): bool
    {
        $isContain = false;
        foreach ($this->excludedWords as $word) {
            if (strpos($path, $word) !== false) {
                $isContain = true;
            }
        }
        return $isContain;
    }

    public function find(): array
    {
        $recursiveDirectoryIterator = new RecursiveDirectoryIterator($this->path);
        $recursiveIteratorIterator = new RecursiveIteratorIterator($recursiveDirectoryIterator);

        foreach ($recursiveIteratorIterator as $info) {
            if (
                $info->isFile()
                && !$this->checkIsExcluded($info->getPathName())
                && strpos($info->getPathName(), '.') !== false
            ) {
                $extension = File::getExtension($info->getPathName());
                if (!isset($this->extensions[$extension])) {
                    $this->extensions[$extension] = 1;
                } else {
                    $this->extensions[$extension]++;
                }
            }
        }
        dd($this->extensions);
        return ['php' => 50];
    }
}
