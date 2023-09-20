<?php namespace App\Commands\Scss;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\OutputStyle;

class ScssCompile extends BaseCommand
{
	/**
	 * Command grouping.
	 *
	 * @var string
	 */
	protected $group = 'scss';

	/**
	 * The Command's name
	 *
	 * @var string
	 */
	protected $name = 'scss:compile';

	/**
	 * the Command's short description
	 *
	 * @var string
	 */
	protected $description = 'Compile scss into css file';

	/**
	 * the Command's usage
	 *
	 * @var string
	 */
	protected $usage = 'scss:compile [driver]';

	/**
	 * the Command's Arguments
	 *
	 * @var array
	 */
	protected $arguments = [];

    /**
     * Creates a new migration file with the current timestamp.
     *
     * @param array $params
     * @throws \ScssPhp\ScssPhp\Exception\SassException
     */
	public function run(array $params = [])
	{
		
		$scssCompiler = new Compiler();

		$pathConfig = config('Paths');
		$viewPath = $pathConfig->viewDirectory;
		$scssBasePath = realpath($viewPath . '/Assets/Scss');

		$cssLessConfig = config('Css');

		foreach ($cssLessConfig->filesConfig as $IOFile) {

		    try {
                $lessInputFile = realpath($viewPath . $IOFile['input']);
                $cssOutputFile = FCPATH . $IOFile['output'];

                $scssFileContent = file_get_contents($lessInputFile);

                $scssCompiler->setOutputStyle(OutputStyle::COMPRESSED);
                $scssCompiler->setImportPaths($scssBasePath);

                $cssResult = $scssCompiler->compileString($scssFileContent)->getCss();

                file_put_contents($cssOutputFile, $cssResult);
            } catch (\Exception $exception) {
		        log_message(1, $exception);
		        continue;
            }
        }
	}
}
