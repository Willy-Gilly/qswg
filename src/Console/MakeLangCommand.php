<?php

namespace WillyGilly\Qswg\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeLangCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:lang {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a lang file';

    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected Filesystem $files;

    /**
     * Create a new command instance.
     * @param Filesystem $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * @return string
     */
    public function getStubPath(): string
    {
        return __DIR__ . '/stubs/lang.stub';
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param string $path
     * @return string
     */
    protected function makeDirectory(string $path): string
    {
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }
        return $path;
    }

    /**
     * Get the full path of generate file
     *
     * @param $lang
     * @return string
     */
    public function getSourceFilePath($lang): string
    {
        return base_path('resources\\lang\\' . $lang . '\\')
            . strtolower($this->argument('name'))
            .'.php';
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $contents = file_get_contents($this->getStubPath());

        foreach (config('qswg.lang') as $lang)
        {
            $path = $this->getSourceFilePath($lang);

            $this->makeDirectory(dirname($path));

            if (!$this->files->exists($path)) {
                $this->files->put($path, $contents);
                $this->info("File : {$path} created");
            } else {
                $this->info("File : {$path} already exits");
            }
        }

    }
}
