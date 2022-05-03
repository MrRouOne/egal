<?php /** @noinspection PhpMissingFieldTypeInspection */

namespace App\Providers;

use Egal\Model\ModelManager;
use Illuminate\Support\ServiceProvider;

class DebugModelsServiceProvider extends ServiceProvider
{
    public string $class;
    public bool $debugMode;
    public string $dir;

    public function __construct($app)
    {
        parent::__construct($app);
        $this->setDir();
        $this->setDebugModel();
        $this->scanModels($this->dir);
    }

    protected function setDir()
    {
        // вынести в config
        $this->dir = env('DEBUG_MODEL_ROOT');
    }

    protected function setDebugModel()
    {
        $this->debugMode = env('DEBUG_MODEL_INCLUDE', false);
    }

    protected function scanModels(?string $dir = null): void
    {
        $baseDir = base_path('app/DebugModels/');

        // тернарный оператор или оператор ??
        if ($dir === null) {
            $dir = $baseDir;
        }

        // namespace зависит от директории, соответственно формируем на основе baseDir
        $modelsNamespace = 'App\DebugModels\\';

        foreach (scandir($dir) as $dirItem) {
            $itemPath = str_replace('//', '/', $dir . '/' . $dirItem);

            if ($dirItem === '.' || $dirItem === '..') {
                continue;
            }

            if (is_dir($itemPath)) {
                $this->scanModels($itemPath);
            }

            if (!str_contains($dirItem, '.php')) {
                continue;
            }

            $classShortName = str_replace('.php', '', $dirItem);
            if (!preg_match("/^[a-z]+(Debug)$/i", $classShortName)) {
                continue;
            }
            $class = str_replace($dir, '', $itemPath);
            $class = str_replace($dirItem, $classShortName, $class);
            $class = str_replace('/', '\\', $class);
            // классов может быть много
            $this->class = $modelsNamespace . $class;
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if ($this->debugMode) {
            ModelManager::loadModel($this->class);
            // зачем?
            $this->commands([]);
        }
    }
}
