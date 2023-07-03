<?php


namespace App\Helpers\Faker;


use Carbon\Carbon;
use Faker\Generator;

class DhivehiContentBlock
{
    private DhivehiFaker $dhivehi_faker;

    public array $content;

    private Generator $faker;

    /**
     * Images to use in image content blocks.
     * Right now only Javaabu banner and a portrait of Kermit The Frog
     *
     * @var string[]
     */
    private $image_urls = ['https://i.imgur.com/2kNwq35.png', 'https://i.imgur.com/6FvzSpS.jpg'];

    /** @var string EditorJS version */
    private $version = '2.19.3';

    public function __construct($lite = false, $even_lite = false)
    {
        // Load up the classes to be used locally.
        $this->dhivehi_faker = new DhivehiFaker();
        $this->faker = new Generator();

        // Do the thing
        $this->init_time();

        if (! $lite && ! $even_lite) {
            $this->construct_blocks();
        } elseif ($lite && ! $even_lite) {
            $this->construct_blocks_lite();
        } else {
            $this->construct_blocks_even_lite();
        }

        $this->set_version();
    }

    private function construct_blocks()
    {
        $this->content['blocks'] = $this->init_heading_blocks();
        $this->content['blocks'][] = $this->init_paragraph_block();

        foreach (['ordered', 'unordered'] as $type) {
            $this->content['blocks'][] = $this->init_list_block($type);
        }

        $this->content['blocks'][] = $this->init_quote_block();
        $this->content['blocks'][] = $this->init_table_block();

        $this->content['blocks'][] = $this->init_media_image_block();

        $this->content['blocks'][] = $this->init_action_block();
    }

    private function construct_blocks_lite()
    {
        $this->content['blocks'] = $this->init_heading_blocks(1);
        $this->content['blocks'][] = $this->init_paragraph_block();
        $this->content['blocks'][] = $this->init_quote_block();
        $this->content['blocks'][] = $this->init_media_image_block();
    }

    private function construct_blocks_even_lite()
    {
        $this->content['blocks'] = $this->init_paragraph_block();
    }

    public function get()
    {
        return json_encode($this->content);
    }

    private function init_time()
    {
        $this->content['time'] = Carbon::now()->unix();
    }

    private function set_version()
    {
        $this->content['version'] = $this->version;
    }

    private function init_heading_blocks($count = 7): array
    {
        $heading_blocks = [];

        for ($i = 1; $i < $count; $i++) {
            $heading_blocks[] = [
                'type' => 'header',
                'data' => [
                    'text'  => "Heading $i",
                    'level' => $i,
                ],
            ];
        }

        return $heading_blocks;
    }

    private function init_paragraph_block(): array
    {
        return [
            'type' => 'paragraph',
            'data' => [
                'text' => $this->dhivehi_faker->words(30),
            ],
        ];
    }

    private function init_list_block(string $style): array
    {
        return [
            'type' => 'list',
            'data' => [
                'style' => $style,
                'items' => ['List Item One', 'List Item Two', 'List Item Three'],
            ],
        ];
    }

    private function init_quote_block(): array
    {
        return [
            'type' => 'quote',
            'data' => [
                'text'      => 'Sample Quote',
                'caption'   => 'Sample person',
                'alignment' => 'left',
            ],
        ];
    }

    private function init_table_block(): array
    {
        $table_content = [];

        $rows = $this->faker->numberBetween(3, 12);
        $columns = $this->faker->numberBetween(3, 12);


        for ($i = 1; $i < $rows; $i++) {
            // Make them bold if they are the first items.
            if ($i == 1) {
                $table_heading_data = [];

                for ($j = 1; $j < $columns; $j++) {
                    $table_heading_data[] = "<b>Column $j</b>";
                }

                $table_content[] = $table_heading_data;
            }

            $table_data = [];

            for ($j = 1; $j < $columns; $j++) {
                $table_data[] = $this->dhivehi_faker->words(3);
            }

            $table_content[] = $table_data;
        }

        return [
            'type' => 'table',
            'data' => [
                'content' => $table_content,
            ],
        ];
    }

    private function init_media_image_block(): array
    {
        return [
            'type' => 'image',
            'data' => [
                'file' => [
                    "url"      => \Arr::random($this->image_urls),
                    "original" => \Arr::random($this->image_urls),
                ],
            ],
        ];
    }

    private function init_action_block(): array
    {
        return [
            'type' => 'action_card',
            'data' => [
                'media'     => $this->faker->numberBetween(1, 10),
                'image_url' => \Arr::random($this->image_urls),
                'url'       => 'https://javaabu.com',
                'text'      => $this->dhivehi_faker->words(10),
                'title'     => $this->dhivehi_faker->words(4),
                'btn_text'  => $this->dhivehi_faker->words(2),
            ],
        ];
    }
}
