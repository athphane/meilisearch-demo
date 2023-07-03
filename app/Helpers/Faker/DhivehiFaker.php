<?php


namespace App\Helpers\Faker;


use Thaana\Thaana;

class DhivehiFaker
{
    /**
     * @var int
     */
    private $sentence_length;

    /**
     * @var int
     */
    private $paragraph_length;

    /**
     * DhivehiFaker constructor.
     *
     * @param  int     $sentence_length
     * @param  int     $paragraph_length
     */
    public function __construct(int $sentence_length = 3, int $paragraph_length = 3)
    {
        $this->sentence_length = $sentence_length;
        $this->paragraph_length = $paragraph_length;

        $this->word_list = $this->loadWordsList();
        $this->endings_list = $this->loadEndingsList();
    }

    private function loadWordsList(): array
    {
        return ThaanaWords::$words;
    }

    private function loadEndingsList(): array
    {
        return Endings::$endings;
    }

    public function word(): string
    {
        return $this->word_list[array_rand($this->word_list)];
    }

    public function words($count, $as_array = False)
    {
        $words = array_rand($this->word_list, $count);

        $the_words = [];

        for ($i = 0; $i < sizeof($words); $i++) {
            array_push($the_words, $this->word_list[$words[$i]]);
        }

        if (! $as_array) {
            return implode(' ', $the_words);
        }

        return $the_words;
    }

    public function ending(): string
    {
        return $this->endings_list[array_rand($this->endings_list)];
    }

    public function sentence(): string
    {
        $sentence = $this->words($this->sentence_length);
        $ending = $this->ending();

        return $sentence . ' ' . $ending;
    }

    public function sentences(int $count, bool $as_array = False)
    {
        $sentences = [];

        for ($i = 0; $i < $count; $i++) {
            array_push($sentences, $this->sentence());
        }

        if (! $as_array) {
            return implode(' ', $sentences);
        }

        return $sentences;
    }

    public static function transliterate($input_string)
    {
        return Thaana::transliterate($input_string);
    }
}
