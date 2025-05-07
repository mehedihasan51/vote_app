<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Models\Post;
use App\Models\Survey;
use App\Helpers\Helper;
use App\Models\SurveyVote;
use Illuminate\Http\Request;
use App\Models\SurveyOpinion;
use App\Http\Controllers\Controller;

class SurveyVoteController extends Controller
{

public function showResults(Request $request, Survey $survey)
{
    $request->validate([
        'opinion_id' => 'required|exists:survey_opinions,id',
    ]);

    $userId = auth()->id();

    if (!$userId) {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }

    // Store single vote
    SurveyVote::create([
        'survey_id' => $survey->id,
        'survey_opinion_id' => $request->opinion_id,
        'user_id' => $userId,
    ]);

    // Count total votes for this survey
    $totalVotes = SurveyVote::where('survey_id', $survey->id)->count();

    // Calculate vote count and percentage for each opinion
    $results = SurveyOpinion::where('survey_id', $survey->id)
        ->withCount(['votes as vote_count' => function ($query) use ($survey) {
            $query->where('survey_id', $survey->id);
        }])
        ->get()
        ->map(function ($opinion) use ($totalVotes) {
            $percentage = $totalVotes > 0 ? round(($opinion->vote_count / $totalVotes) * 100, 2) : 0;
            return [
                'opinion_text' => $opinion->opinion,
                'votes' => $opinion->vote_count,
                'percentage' => $percentage,
            ];
        });

    return response()->json([
        'total_votes' => $totalVotes,
        'end_date'=> $survey->end_date,
        'results' => $results,
    ]);
}

}