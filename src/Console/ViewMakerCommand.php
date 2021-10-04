<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ViewMakerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view {name} {path=nopath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a blade view';

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
        return __DIR__ . '/stubs/view.stub';
    }
    /**
     * @return array
     * Get Stub Variables
     */
    public function getStubVariables(): array
    {
        return [
            'title' => $this->getViewName($this->argument('name')),
        ];
    }

    /**
     * @param string $viewName
     * @return string
     */
    public function getViewName(string $viewName): string
    {
        return $viewName;
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return array|bool|string
     */
    public function getSourceFile(): array|bool|string
    {
        return $this->getStubContents($this->getStubPath(), $this->getStubVariables());
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return array|bool|string
     */
    public function getStubContents($stub , array $stubVariables = []): array|bool|string
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace)
        {
            $contents = str_replace('$'.$search.'$' , $replace, $contents);
        }
        return $contents;
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePath(): string
    {
        if($this->argument('path') != "nopath")
        {
            $chdir = $this->argument('path') . '\\';
        }
        else {
            $chdir = '';
        }
        return base_path('resources\\views\\' . $chdir)
            . $this->getViewName($this->argument('name'))
            .'.blade.php';
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
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $path = $this->getSourceFilePath();

        $this->makeDirectory(dirname($path));

        $contents = $this->getSourceFile();

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("File : {$path} created");
        } else {
            $this->info("File : {$path} already exits");
        }
    }

}
