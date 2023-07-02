<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MeilisearchResetCommand extends Command
{
    protected $signature = 'meilisearch:reset';

    protected $description = 'Command description';

    public function handle(): void
    {
        $models = [
            'App\Models\Legislation',
            'App\Models\Consolidation',
            'App\Models\Section',
        ];

        foreach ($models as $model) {
            $this->call('scout:flush', ['model' => $model]);
        }

        foreach ($models as $model) {
            $this->call('scout:import', ['model' => $model]);
        }
    }
}
