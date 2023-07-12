<?php

namespace Tests\Unit;

use App\Models\Question;
use PHPUnit\Framework\TestCase;

class QuestionTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testGetCorrectOptionCount()
    {

        $question = new Question;
        $question->options = ['Option A', 'Option B', 'Option C'];
        $question->correct_option = 1;


        $correctOptionCount = $question->getCorrectOptionCount();
        $this->assertEquals(1, $correctOptionCount);
    }

    public function testGetByTitle()
    {
        $questions = Question::getByTitle('keyword');

        // $this->assertTrue(...);
    }

    public function testOrderByCorrectOptionCount()
    {

        $questions = Question::orderByCorrectOptionCount();

        // $this->assertTrue(...);
    }
}
