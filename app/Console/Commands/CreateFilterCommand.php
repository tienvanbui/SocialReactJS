<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateFilterCommand extends Command
{
    public const FILTER_DIR_PATH = 'app/Models/Filters/';

    protected $modelFilterName;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:filter {modelFilter}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create model filter';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->modelFilterName = $this->argument('modelFilter');

        if (!$this->IsExistsDirectory()) {
            $this->createFiltersDirectory();
        }


        if ($this->IsExistsFilterFile()) {
            $this->error('Filter File Is Valid');
            return;
        }

        $this->createModelFilterFile();

        $this->info("{$this->modelFilterName}Filter created successfully!");
    }

    public function IsExistsDirectory()
    {
        $pathFile = self::FILTER_DIR_PATH;
        return file_exists($pathFile);
    }

    public function createFiltersDirectory()
    {
        $pathFile = self::FILTER_DIR_PATH;
        mkdir($pathFile, 0775, true);
    }

    public function IsExistsFilterFile()
    {
        $pathFile = self::FILTER_DIR_PATH . $this->modelFilterName . 'Filter.php';
        return file_exists($pathFile);
    }

    public function createModelFilterFile()
    {
        $content = <<<EOD
        <?php 

            namespace App\Models\Filters;

            use Illuminate\Database\Eloquent\Builder;
            use Illuminate\Http\Request;

            class {$this->modelFilterName}Filter extends Filters {

        EOD;

        $content .= "\n\t\t" . 'protected $request;' . "\n\t\t" .  'public function __construct(Request $request) {' . "\n\t\t\t"
            . '$this->request = $request;'. "\n\t\t}\n\t\t" . 'public function getQuery(Builder $query): Builder {' . "\n\t\t\t" . 'return $query;' . "\n\t\t}\n}";

        file_put_contents(self::FILTER_DIR_PATH . $this->modelFilterName . 'Filter.php', $content);
    }
}
