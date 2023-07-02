<?php

namespace App\Http\Controllers;

use App\Models\Consolidation;
use App\Models\Legislation;
use App\Models\ReadOnlyConsolidation;
use App\Models\ReadOnlySection;
use App\Models\Section;
use Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $search_term = 'et';

        $highlighter = function ($meiliSearch, string $query, array $options) {
            $options['attributesToHighlight'] = ['*'];
            $options['attributesToCrop'] = ['text'];
            $options['cropLength'] = 15;

            return $meiliSearch->search($query, $options);
        };

        // first find legislations that match the search parameter
        $legislations = Legislation::search($search_term, $highlighter)->get();

        $legislations->transform(function (Legislation $legislation) use ($highlighter, $search_term) {
            $consolidation_ids = $legislation->consolidations()->pluck('id')->toArray();

            // Search consolidations separately
            $consolidations = Consolidation::search($search_term, $highlighter)
                ->whereIn('id', $consolidation_ids)
                ->raw();

            $consolidations = $this->applyHighlightsToConsolidations($consolidations);

            // Search sections separately
            $sections = Section::search($search_term, $highlighter)
                ->whereIn('consolidation_id', $consolidation_ids)
                ->raw();

            $sections = $this->applyHighlightsToSections($sections);

            $merged_consolidations_and_sections = $this->mergeConsolidationsAndSections($consolidations, $sections);

            // add consolidation from $merged_consolidations_and_sections to $legislation where legislation_id matches
            $legislation['consolidations'] = $merged_consolidations_and_sections;

            return $legislation;
        });

        // then go through each of their consolidations and find the ones that match the search parameter

        // then go through all of the sections of each consolidation and find the ones that match the search parameter

        return $legislations;
    }

    public function applyHighlightsToSections($sections)
    {
        return collect($sections['hits'])->transform(function ($raw_section) {
            $formatted = Arr::get($raw_section, '_formatted');

            $eloquent_section = ReadOnlySection::find($formatted['id']);

            $eloquent_section->title = $formatted['title'];
            $eloquent_section->text = $formatted['text'];

            return $eloquent_section;
        });
    }

    public function applyHighlightsToConsolidations($consolidations)
    {
        return collect($consolidations['hits'])->transform(function ($raw_consolidation) {
            $formatted = Arr::get($raw_consolidation, '_formatted');

            $eloquent_section = ReadOnlyConsolidation::find($formatted['id']);

            $eloquent_section->title = $formatted['title'];
            $eloquent_section->description = $formatted['description'];

            return $eloquent_section;
        });
    }

    public function mergeConsolidationsAndSections(Collection $consolidations, Collection $sections)
    {
        // get all consolidation_ids from sections
        $section_consolidation_ids = $sections->pluck('consolidation_id')->toArray();

        // get all ids from consolidations
        $consolidation_ids = $consolidations->pluck('id')->toArray();

        // find $section_consolidation_ids that are not in $consolidation_ids
        $consolidation_ids_to_add = array_diff($section_consolidation_ids, $consolidation_ids);

        // Get ReadOnlyConsolidation models for $consolidation_ids_to_add
        $consolidations_to_add = ReadOnlyConsolidation::whereIn('id', $consolidation_ids_to_add)->get();

        // merge $consolidations and $consolidations_to_add
        $consolidations = $consolidations->merge($consolidations_to_add);

        // add sections from $section to $consolidations_to_add that matches the consolidation_id
        $consolidations->transform(function (ReadOnlyConsolidation $consolidation) use ($sections) {
            $consolidation->sections = $sections->where('consolidation_id', $consolidation->id)->values();

            return $consolidation;
        });

        return $consolidations_to_add;
    }
}
