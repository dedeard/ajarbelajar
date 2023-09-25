<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\Artisan;

class FactoryCommand extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'factory {model} {total}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate factory data for a model';

    /**
     * Prompt for missing arguments using custom questions.
     *
     * @return array
     */
    protected function promptForMissingArgumentsUsing()
    {
        return [
            'model' => 'What is the model name?',
            'total' => 'How many data do you want to generate?',
        ];
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $model = $this->argument('model');
        $total = (int) $this->argument('total');

        if ($this->confirm("Do you want to generate {$total} instances of {$model}?")) {
            $namespacedModel = "App\\Models\\" . ucfirst($model);
            if (class_exists($namespacedModel)) {
                $namespacedModel::factory()->count($total)->create();
                $this->info("{$total} instances of {$model} have been generated.");
            } else {
                $this->error("The model {$namespacedModel} does not exist.");
            }
        }
    }
}
