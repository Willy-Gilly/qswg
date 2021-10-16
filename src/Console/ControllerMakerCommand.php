<?php

namespace WillyGilly\Qswg\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use JetBrains\PhpStorm\ArrayShape;

class ControllerMakerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'controller:make {classname} {extendsname}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a controller extending from an other';

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
     * Get Stub Path
     */
    public function getStubPath(): string
    {
        return __DIR__ . '/stubs/controller.stub';
    }

    /**
     * @return array
     * Get Stub Variables
     */
    public function getStubVariables(): array
    {
        return [
            'class' => (str_contains($string, '/')) ? substr(strrchr($this->getClassName($this->argument('classname')), "/"), 1) : $this->getClassName($this->argument('classname'),
            'extends' => $this->getExtendsClassName($this->argument('extendsname')),
        ];
    }

    /**
     * @param $classname
     * @return string
     */
    public function getClassName($classname): string
    {
        return ucwords($classname);
    }

    /**
     * @param $extendsname
     * @return string
     */
    public function getExtendsClassName($extendsname): string
    {
        return (strtolower($extendsname) == "api") ? strtoupper($extendsname) : ucwords($extendsname);
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
        return base_path('App\\Http\\Controllers\\'.$this->getExtendsClassName($this->argument('extendsname')))
            . '\\' . $this->getClassName($this->argument('classname')) .
            $this->getExtendsClassName($this->argument('extendsname')) .'Controller.php';
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
