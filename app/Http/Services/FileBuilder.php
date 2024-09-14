<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Storage;

class FileBuilder
{
    protected $file;
    protected $path;
    protected $format;
    protected $fileName;
    protected $disk;
    protected $finalPath;

    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }
    public function getPath()
    {
        return $this->path;
    }
    public function setPath($path)
    {
        $this->path = trim($path, '/\\');
        return $this;
    }
    public function getName()
    {
        return $this->fileName;
    }
    public function setName($fileName)
    {
        $this->fileName = $fileName;
        return $this;
    }
    public function getFinalPath()
    {
        return $this->finalPath;
    }
    public function setFinalPath($finalPath)
    {
        $this->finalPath = $finalPath;
        return $this;
    }
    public function getFormat()
    {
        return $this->format;
    }
    public function setFormat($format)
    {
        $this->format = $format;
    }
    protected function checkPath($path)
    {
        if (!Storage::disk($this->disk)->exists($path)) {
            Storage::disk($this->disk)->makeDirectory($path);
        }
    }
    protected function provider()
    {
        $this->getPath() ??  $this->setPath(date('Y') . DIRECTORY_SEPARATOR . date('m') . DIRECTORY_SEPARATOR . date('d'));
        $this->getName() ?? $this->setName(time());
        $this->getFormat() ?? $this->setFormat($this->file->extension());
        $this->setName($this->getName() .time(). '.' . $this->getFormat());
        $this->checkPath($this->getPath());
        return $this;


    }

}
