<?php

namespace Tests\Unit;

use App\Models\TextModel;
use Tests\TestCase;

class TextModelTest extends TestCase
{

    public function test_getWordCountAttribute()
    {
        $text = TextModel::where('id', 13)->first();
        $this->assertTrue($text->word_count == 8);
    }

    public function test_getAverageTimeAttribute()
    {
        $text = TextModel::where('id', 16)->first();
        $this->assertTrue($text->average_time == 19.82);
    }

    public function test_category() {
        $text = TextModel::where('id', 16)->first();
        $this->assertTrue($text->category()->naziv == 'engleski');
    }

    public function test_search() {
        $this->assertTrue(sizeof(TextModel::search(0, 3, 3, 1)->items()) == 2);
        $this->assertTrue(sizeof(TextModel::search(0, 2, 2, 1)->items()) == 1);
        $this->assertTrue(sizeof(TextModel::search(0, 0, 0, 1)->items()) == 5);
    }

    public function test_duzinaCategory() {
        $text = TextModel::where('id', 13)->first();
        $this->assertTrue($text->duzinaCategory() == 1);
    }

    public function test_tezinaCategory() {
        $text = TextModel::where('id', 13)->first();
        $this->assertTrue($text->tezinaCategory() == 1);
    }

    public function test_firstWords() {
        $text = TextModel::where('id', 13)->first();
        $this->assertTrue($text->firstWords(50) == $text->sadrzaj);
    }

    public function test_cleanText() {
        $text = TextModel::where('id', 13)->first();
        $this->assertTrue($text->cleanText() == $text->sadrzaj);
    }

}
