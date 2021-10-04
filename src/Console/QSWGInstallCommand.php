<?php

namespace WillyGilly\Qswg\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class QSWGInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qswg:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Willy Gilly\'s quickstart laravel fresh install : main folders, main controllers and first email';
    /**
     * @var Filesystem
     */
    protected Filesystem $files;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param string $path
     * @return string
     */
    protected function makeDirectory(string $path): string
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }
        return $path;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->makeAllDirectories();
        $this->placesStubs();
    }

    public function makeAllDirectories(): void
    {
        $this->makeDirectory(base_path('App\\Http\\Controllers\\API\\'));
        $this->makeDirectory(base_path('App\\Http\\Controllers\\API\\Auth'));
        $this->makeDirectory(base_path('App\\Http\\Controllers\\Email\\'));
        $this->makeDirectory(base_path('App\\Http\\Controllers\\Model\\'));
        $this->makeDirectory(base_path('App\\Http\\Controllers\\View\\'));
        $this->makeDirectory(base_path('App\\Mail\\'));
        $this->makeDirectory(base_path('public\\css\\'));
        $this->makeDirectory(base_path('public\\image\\'));
        $this->makeDirectory(base_path('public\\js\\'));
        $this->makeDirectory(base_path('resources\\views\\errors\\'));
        $this->makeDirectory(base_path('resources\\views\\mail\\'));
        $this->makeDirectory(base_path('resources\\views\\partial\\'));
    }

    /**
     * @return void
     */
    public function placesStubs(): void
    {
        $stubs = [
            [__DIR__ . '/stubs/apilogincontroller.stub',base_path('App\\Http\\Controllers\\API\\Auth\\LoginController.php')],
            [__DIR__ . '/stubs/apimaincontroller.stub',base_path('App\\Http\\Controllers\\API\\APIController.php')],
            [__DIR__ . '/stubs/mailcontroller.stub',base_path('App\\Http\\Controllers\\Email\\EmailController.php')],
            [__DIR__ . '/stubs/testbladephp.stub',base_path('resources\\views\\mail\\test.blade.php')],
            [__DIR__ . '/stubs/testmail.stub',base_path('App\\Mail\\TestMail.php')],
            [__DIR__ . '/stubs/viewcontroller.stub',base_path('App\\Http\\Controllers\\View\\ViewController.php')],
            [__DIR__ . '/stubs/setlocale.stub',base_path('App\\Http\\Middleware\\SetLocale.php')],
            [__DIR__ . '/stubs/forcejsonresponse.stub',base_path('App\\Http\\Middleware\\ForceJsonResponse.php')]
        ];
        foreach ($stubs as $stub)
        {
            if (!$this->files->exists($stub[1])) {
                $this->files->put($stub[1], $this->getStubContents($stub[0]));
                $this->info("File : {$stub[1]} created");
            } else {
                $this->info("File : {$stub[1]} already exits");
            }
        }
    }

    public function getStubContents($stub): array|bool|string
    {
        return  file_get_contents($stub);
    }
}
