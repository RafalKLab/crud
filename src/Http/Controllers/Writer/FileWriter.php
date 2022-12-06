<?php

namespace Rklab\Crud\Http\Controllers\Writer;

use Illuminate\Support\Facades\File;

class FileWriter implements FileWriterInterface
{
    public function createDirectory(string $destination): void
    {
        $path = dirname($destination);
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
    }

    public function putTextInFile(string $destination, string $migrationFile): void
    {
        File::put($destination, $migrationFile);
    }
}
