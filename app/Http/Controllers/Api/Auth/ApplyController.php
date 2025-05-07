<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApplyController extends Controller
{

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'type'                          => 'required|in:representative,senator',
            'nid'                           => 'required',
            'cityzenship'                   => 'required|string|max:50',
            'postal_code'                   => 'required|string|max:50',
            'district'                      => 'required|string|max:50',
            'subdistrict'                   => 'required|string|max:50',
            'year_of_residence'             => 'required|string|max:50',
            'higest_education'              => 'required|string|max:50',
            'institution'                   => 'required|string|max:255',
            'year_of_completion'            => 'required|string|max:50',
            'political_statment'            => 'nullable|string',
            'previous_political_position'   => 'nullable|string',
            'political_experience'          => 'nullable|string',
            'political_platform_summary'    => 'nullable|string',
            'key_policy_political'          => 'nullable|string',
            'current_occupation'            => 'required|string|max:50',
            'year_of_experience'            => 'nullable|string|max:50',
            'relavent_skills'               => 'nullable|string|max:255',
            'focus'                         => 'required|array',
            'focus.*'                       => 'required|exists:foci,id',
            'agree'                         => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return Helper::jsonResponse(false, 'Validation failed', 422, $validator->errors());
        }

        try {
            $data = $validator->validated();

            $user = Auth::guard('api')->user();

            $profile = $user->profile;

            if (!$profile) {
                return Helper::jsonResponse(false, 'Profile not found', 404);
            }

            $profile->update([
                'user_id'                       => $user->id,
                'type'                          => $data['type'],
                'nid'                           => $data['nid'],
                'cityzenship'                   => $data['cityzenship'],
                'postal_code'                   => $data['postal_code'],
                'district'                      => $data['district'],
                'subdistrict'                   => $data['subdistrict'],
                'year_of_residence'             => $data['year_of_residence'],
                'higest_education'              => $data['higest_education'],
                'institution'                   => $data['institution'],
                'year_of_completion'            => $data['year_of_completion'],
                'political_statment'            => $data['political_statment'] ?? null,
                'previous_political_position'   => $data['previous_political_position'] ?? null,
                'political_experience'          => $data['political_experience'] ?? null,
                'political_platform_summary'    => $data['political_platform_summary'] ?? null,
                'key_policy_political'          => $data['key_policy_political'] ?? null,
                'current_occupation'            => $data['current_occupation'],
                'year_of_experience'            => $data['year_of_experience'] ?? null,
                'relavent_skills'               => $data['relavent_skills'] ?? null
            ]);

            DB::table('foci_profiles')->where('profile_id', $profile->id)->delete();

            foreach ($data['focus'] as $focus) {
                DB::table('foci_profiles')->insert([
                    'profile_id' => $profile->id,
                    'focus_id' => $focus
                ]);
            }

            $user->applies()->create([
                'user_id' => $user->id,
                'agree' => $data['agree'],
                'type' => $data['type'],
                'status' => 'pending'
            ]);

            return Helper::jsonResponse(true, 'Profile updated successfully', 200, $user);
        } catch (Exception $e) {
            return Helper::jsonResponse(false, $e->getMessage(), 500);
        }
    }

}

