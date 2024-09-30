<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateRepositoryFileCommand extends Command
{
    public const REPOSITORIES_PATH = 'app/Repositories/';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {repositoryName} {--interface=: Interface Name File} {--i|--ignore : Whether to check if the model exists}';

    protected $className;

    protected $dirName;

    protected $ignore;

    protected $repositoryName;

    protected $interfaceRepositoryName;

    protected $repositoryPathFile;

    protected $interfaceRepositoryPathFile;


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create repository and repository interface';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->className = $this->argument('repositoryName');

        if (!$this->className) {
            $this->error('Repository Name Invalid.');
            return;
        }

        $this->ignore = $this->option('ignore');
        
        if (!$this->isModelExists() && $this->ignore) {
            $this->error('Model Is Invalid.');
            return;
        }

        $this->dirName = $this->className;

        if (!$this->isDirectoryExists()) {
            $this->createDirectoryRepository();
        }

        $this->repositoryPathFile = self::REPOSITORIES_PATH . $this->dirName . '/' . $this->className . 'Repository.php';
        $this->interfaceRepositoryPathFile = self::REPOSITORIES_PATH . $this->dirName . '/' . $this->className . 'RepositoryInterface.php';

        $this->interfaceRepositoryName = $this->option('interface')  ? $this->option('interface') : $this->argument('repositoryName');

        if (!$this->isRepositoryExists()) {
            $this->createRepositoryFile();
            $this->createInterFaceFile();
        }
        $this->info("Created Repository Successfully!");
    }
    /**
     * Create Repository File.
     */
    private function createRepositoryFile(): void
    {
        $content = <<<EOD
            <?php

            declare(strict_types=1);

            namespace App\\Repositories\\{$this->dirName};

            use App\\Models\\{$this->className};\n
            EOD;

        !($this->option('interface')) ?: $content .= "use App\\Repositories\\{$this->className}\\{$this->className}RepositoryInterface;\n";

        $content .= "\n" . <<<EOD
            class {$this->className}Repository implements {$this->className}RepositoryInterface
            {
                public function __construct(private readonly {$this->className} \$model)
                {
                }
            }

            EOD;

        file_put_contents($this->repositoryPathFile, $content);
    }

    /**
     * Create Interface class for the created Repository class.
     */
    private function createInterFaceFile(): void
    {
        $content = <<<EOD
            <?php

            declare(strict_types=1);

            namespace App\\Repositories\\{$this->dirName};

            interface {$this->className}RepositoryInterface
            {

            }
            EOD;

        file_put_contents($this->interfaceRepositoryPathFile, $content);
    }


    public function isModelExists()
    {
        $model = 'app/Models/' . $this->className . '.php';
        file_exists($model);
    }

    public function isDirectoryExists()
    {
        file_exists(self::REPOSITORIES_PATH . $this->dirName);
    }

    public function createDirectoryRepository()
    {
        mkdir(self::REPOSITORIES_PATH . $this->dirName, 0775, true);
    }

    public function isRepositoryExists()
    {
        file_exists($this->repositoryPathFile) && file_exists($this->interfaceRepositoryPathFile);
    }
}
