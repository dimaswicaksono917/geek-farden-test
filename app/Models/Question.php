<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'questions';
    protected $fillable = [
        'title',
        'content',
        'options',
        'correct_option',
    ];
    protected $casts = [
        'options' => 'array',
    ];

    public function getCorrectOptionCount()
    {
        $correctOption = $this->correct_option;

        // Menghitung jumlah jawaban benar
        $correctOptionCount = 0;
        foreach ($this->options as $index => $option) {
            if ($index === $correctOption) {
                $correctOptionCount++;
            }
        }

        return $correctOptionCount;
    }

    public static function getByTitle($keyword)
    {
        return self::where('title', 'like', '%' . $keyword . '%')->get();
    }

    public static function orderByCorrectOptionCount()
    {
        return self::orderByDesc('correct_option')->get();
    }
}
