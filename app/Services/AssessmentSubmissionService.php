<?php

namespace App\Services;

use App\Models\Assessment;
use App\Models\User;
use App\Models\UserAssessment;
use App\Models\UserAssessmentAnswer;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class AssessmentSubmissionService
{
    /**
     * @return array<int, mixed>
     */
    public function normalizeAnswers(array $answersInput): array
    {
        $answersByQuestionId = [];

        if (array_is_list($answersInput)) {
            foreach ($answersInput as $row) {
                if (! is_array($row)) {
                    continue;
                }
                $qid = $row['question_id'] ?? $row['id'] ?? null;
                $ans = $row['answer'] ?? $row['value'] ?? $row['answer_text'] ?? null;
                if ($qid !== null) {
                    $answersByQuestionId[(int) $qid] = $ans;
                }
            }
        } else {
            foreach ($answersInput as $qid => $ans) {
                if (is_numeric($qid)) {
                    $answersByQuestionId[(int) $qid] = $ans;
                }
            }
        }

        return $answersByQuestionId;
    }

    public function submit(User $user, Assessment $assessment, array $answersByQuestionId): UserAssessment
    {
        if (! $user->isClient()) {
            throw new AuthorizationException('Only customers can submit assessments.');
        }

        if (empty($answersByQuestionId)) {
            throw new InvalidArgumentException('Answers payload is empty or invalid.');
        }

        $assessment->loadMissing(['questions' => fn ($query) => $query->ordered()]);

        return DB::transaction(function () use ($user, $assessment, $answersByQuestionId) {
            $userAssessment = UserAssessment::create([
                'user_id' => $user->id,
                'assessment_id' => $assessment->id,
                'status' => 'completed',
                'started_at' => now(),
                'completed_at' => now(),
            ]);

            $totalScore = 0;
            $maxScore = 0;

            foreach ($assessment->questions as $question) {
                $answerData = $answersByQuestionId[$question->id] ?? null;

                if ($answerData === null && $question->required) {
                    throw new InvalidArgumentException(
                        'Missing answer for required question: '.$question->id
                    );
                }

                if ($answerData === null) {
                    continue;
                }

                $answerText = is_array($answerData) ? json_encode($answerData) : (string) $answerData;
                $answerValue = null;
                $score = 0;

                if (is_numeric($answerData)) {
                    $answerValue = (int) $answerData;
                    $score = $answerValue * ($question->weight ?? 1);
                } elseif (is_string($answerData) && is_numeric(trim($answerData))) {
                    $answerValue = (int) trim($answerData);
                    $score = $answerValue * ($question->weight ?? 1);
                }

                UserAssessmentAnswer::create([
                    'user_assessment_id' => $userAssessment->id,
                    'question_id' => $question->id,
                    'answer_text' => $answerText,
                    'answer_value' => $answerValue,
                    'score' => $score,
                ]);

                $totalScore += $score;
                $maxScore += (int) ($question->weight ?? 1) * 5;
            }

            $percentage = $maxScore > 0 ? round(($totalScore / $maxScore) * 100, 2) : null;

            $userAssessment->update([
                'total_score' => $totalScore,
                'max_score' => $maxScore,
                'percentage' => $percentage,
                'result_summary' => [
                    'total_score' => $totalScore,
                    'max_score' => $maxScore,
                    'percentage' => $percentage,
                ],
            ]);

            return $userAssessment->fresh(['assessment', 'answers.question']);
        });
    }
}
