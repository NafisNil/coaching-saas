<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Attendance;
use App\Models\StudentRiskLog;

class StudentRiskService
{
    public function evaluateStudentRisk(Student $student): void
    {
        $recentAttendances = Attendance::where('student_id', $student->id)
            ->latest('date')
            ->take(10)
            ->get();

        if ($recentAttendances->isEmpty()) return;

        $absentCount = $recentAttendances->where('status', 'absent')->count();
        $totalClasses = $recentAttendances->count();
        $absenceRate = ($absentCount / $totalClasses) * 100;

        $newRiskLevel = 'normal';
        $reasons = [];

        if ($absenceRate >= 40) {
            $newRiskLevel = 'high_risk';
            $reasons[] = "High absence rate ({$absenceRate}% in last {$totalClasses} classes)";
        } elseif ($absenceRate >= 20) {
            $newRiskLevel = 'attention_needed';
            $reasons[] = "Moderate absence rate ({$absenceRate}% in last {$totalClasses} classes)";
        }

        if ($student->risk_level !== $newRiskLevel) {
            $previousLevel = $student->risk_level;

            $student->update([
                'risk_level' => $newRiskLevel,
                'risk_updated_at' => now(),
            ]);

            StudentRiskLog::create([
                'institution_id' => $student->institution_id,
                'student_id' => $student->id,
                'previous_level' => $previousLevel,
                'new_level' => $newRiskLevel,
                'reasons' => $reasons,
                'calculated_at' => now(),
            ]);
        }
    }
}