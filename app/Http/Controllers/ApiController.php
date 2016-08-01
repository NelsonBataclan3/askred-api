<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Question;
use App\Http\Requests;

class ApiController extends Controller
{
    public function addQuestion($asker, $question)
    {
        // Generate hash
        $hash = str_random(16);
        $job = Question::create([
            'question'  =>  $question,
            'asked_by'    =>  $asker,
            'hash'      =>  $hash,
        ]);
        if ($job) {
            return json_encode([
                'status'    =>  200,
                'hash'      =>  $hash
            ]);
        } else {
            return json_encode([
                'status'    =>  400
            ]);
        }
    }

    public function getStatus($hash)
    {
        $job = Question::where('hash', $hash)->first();
        if (!$job) {
            return json_encode([
                'status'    =>  400,
                'message'     =>  'Question is not found.'
            ]);
        } else {
            return json_encode([
                'status'    =>  200,
                'answered'  =>  (!empty($job->answer)),
                'answer'    =>  $job->answer
            ]);
        }
    }
}
