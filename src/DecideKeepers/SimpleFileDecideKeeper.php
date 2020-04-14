<?php

declare(strict_types=1);


namespace App\DecideKeepers;


use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class SimpleFileDecideKeeper implements DecideKeeperInterface
{
    private string $folder = '/tmp';
    private string $fileNameFormat = '%s.status.yaml';

    public function setNotifyStatus(string $source, bool $status): void
    {
        $yaml = Yaml::dump([$source => (int)$status]);
        file_put_contents($this->getFilePath($source), $yaml);
    }

    public function getNotifyStatus(string $source): bool
    {
        $finder = new Finder();
        $files = $finder->files()->name(sprintf($this->fileNameFormat, $source))->in($this->folder);
        if (!$files->count()) {
            return false;
        }
        $value = Yaml::parseFile($this->getFilePath($source));

        return (bool)$value[$source] ?? false;
    }

    private function getFilePath(string $source): string
    {
        return sprintf('%s/' . $this->fileNameFormat, $this->folder, $source);
    }
}