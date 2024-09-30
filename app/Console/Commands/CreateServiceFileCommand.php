<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateServiceFileCommand extends Command
{
    protected $className;

    protected const SERVICE_PATH_FILE = 'app/Services/';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {serviceName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new service file';

    /**
     * Create Service File.
     */
    private function createServiceFileContent($serviceFileName): void
    {
        $content = "<?php\n\ndeclare(strict_types=1);\n\nnamespace App\\Services;\n\nclass {$this->className}Service\n{\n}\n";
        file_put_contents($serviceFileName, $content);
    }

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->className = $this->argument('serviceName');

        if (!$this->className) {
            $this->info('Service Name Is Invalid');
            return;
        }

        if (!$this->isExistsDirectory()) {
            $this->createServiceDirectory();
        }

        $serviceFileName = self::SERVICE_PATH_FILE . $this->className . 'Service.php';

        if (file_exists($serviceFileName)) {
            $this->error('Service File is exists!');
            return;
        }

        $this->createServiceFileContent($serviceFileName);

        $this->info('Service File was successfully!');
    }

    public function isExistsDirectory()
    {
        return file_exists(self::SERVICE_PATH_FILE);
    }

    public function createServiceDirectory()
    {
        mkdir(self::SERVICE_PATH_FILE, 0775, true);
    }
}
