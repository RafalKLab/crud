<?php

namespace Rklab\Crud\Http\Controllers\Writer;

interface FileWriterInterface
{
    public function createDirectory(string $destination): void;

    public function putTextInFile(string $destination, string $fileContent): void;
}
