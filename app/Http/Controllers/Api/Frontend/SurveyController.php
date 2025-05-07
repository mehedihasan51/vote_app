<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Post;
use App\Models\Survey;

class SurveyController extends Controller
{

    public function show()
    {
        $surveys = Survey::where('status', 'active')->get(); // returns collection
    
        $data = $surveys->map(function ($survey) {
            return [
                'title' => $survey->title,
                'description' => $survey->description
            ];
        });
    
        return Helper::jsonResponse(true, 'Get all active surveys', 200, $data);
    }
    
}