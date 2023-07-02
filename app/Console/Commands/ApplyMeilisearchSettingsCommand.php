<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Meilisearch\Client;

class ApplyMeilisearchSettingsCommand extends Command
{
    protected $signature = 'meilisearch:update-index';

    protected $description = 'Command description';

    public function handle(): void
    {
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));

        $client->index('consolidations_index')->updateFilterableAttributes(['id', 'legislation_id']);
        $client->index('consolidations_index')->updateFilterableAttributes(['id', 'legislation_id']);
        $client->index('sections_index')->updateFilterableAttributes(['consolidation_id']);
    }
}
