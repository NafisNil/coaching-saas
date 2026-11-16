<?php
namespace App\Services;

use App\Models\StudentTopicAnalytic;
use App\Models\Student;
use App\Models\Topic;

class LearningGapService
{
    public function recordTopicPerformance(Student $student, Topic $topic, bool $isCorrect): void
    {
        $analytic = StudentTopicAnalytic::firstOrCreate(
            [
                'institution_id' => $student->institution_id,
                'student_id' => $student->id,
                'topic_id' => $topic->id,
            ],
            [
                'total_questions_attempted' => 0,
                'correct_count' => 0,
                'mastery_percentage' => 0.00,
            ]
        );

        $analytic->total_questions_attempted += 1;
        if ($isCorrect) {
            $analytic->correct_count += 1;
        }

        $analytic->mastery_percentage = round(
            ($analytic->correct_count / $analytic->total_questions_attempted) * 100, 
            2
        );
        $analytic->last_assessed_at = now();
        $analytic->save();
    }
}