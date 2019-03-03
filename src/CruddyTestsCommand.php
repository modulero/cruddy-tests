<?php

namespace Modulero\CruddyTests;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CruddyTestsCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:cruddy-tests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new batch of cruddy tests';

    /**
     * The current resource ability.
     *
     * @var string
     */
    protected $currentAbility = '';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = '';

    /**
     * Handle the command.
     *
     * @return void
     */
    public function handle()
    {
        $abilities = empty($this->only())
            ? config('cruddy-tests.abilities')
            : $this->only();

        foreach ($abilities as $ability) {
            if (in_array($ability, $this->except())) {
                continue;
            }

            $this->currentAbility = ucfirst($ability);
            $this->type = $this->currentAbility.$this->argument('name').'Test';

            parent::handle();
        }
    }

    /**
     * Get the full namespace for a given class, without the class name.
     *
     * @param  string  $name
     * @return string
     */
    protected function getNamespace($name)
    {
        return trim(implode('\\', explode('\\', $name)), '\\');
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getDefaultNamespace($this->rootNamespace()).'\\', '', $name);

        return str_replace('DummyClass', $this->currentAbility.$class.'Test', $stub);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return base_path('vendor/laravel/framework/src/Illuminate/Foundation/Console/stubs/test.stub');
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = str_replace($this->rootNamespace(), '', $name);

        return base_path('tests').str_replace('\\', '/', $name).'/'.$this->currentAbility.class_basename($name).'Test.php';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Feature';
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return 'Tests';
    }

    /**
     * Get the only option passed to the command.
     *
     * @return array
     */
    protected function only()
    {
        return array_filter(explode(',', $this->option('only')));
    }

    /**
     * Get the except option passed to the command.
     *
     * @return array
     */
    protected function except()
    {
        return array_filter(explode(',', $this->option('except')));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'Name of the test feature'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['only', null, InputOption::VALUE_OPTIONAL, 'Add the specific abilities you want to make', null],
            ['except', null, InputOption::VALUE_OPTIONAL, 'Exclude the specific abilities you do not want to make', null],
        ];
    }
}
