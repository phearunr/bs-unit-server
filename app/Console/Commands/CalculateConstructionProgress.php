<?php

namespace App\Console\Commands;

use App\Unit;
use App\Project;
use Illuminate\Console\Command;

class CalculateConstructionProgress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'construction:calc {project_code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate unit consturction progress from unit_construction_procedures\'s progress attribute';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $project_code = $this->argument('project_code');

        if ( !$project_code ) {
            $this->error('Project Code is requried.');
            return;
        }

        $project = Project::where('short_code', $project_code)->first();

        if ( !$project ) {
            $this->error('We could not find the project code: '.$project_code);
            return;
        }

        $units = $project->units()->get();

        $bar = $this->output->createProgressBar(count($units));

        $bar->start();

        foreach($units as $unit) {
            $unit->construction_overall_progress = $unit->constructionProcedures()->avg('progress');
            $unit->save();
            $bar->advance();
        }

        $bar->finish();

        $this->info('Done!');
    }
}
