<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class QuestionController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function ask(Request $request): \Illuminate\Http\Response
    {
        $wishlist = Wishlist::query()
            ->find($request->input('list_id'));

        Question::query()
            ->create([
                'user_id' => Auth::user()->getAuthIdentifier(),
                'target_id' => $wishlist->user->id,
                'list_id' => $wishlist->id,
                'alias' => array_rand(config('alias')),
                'message' => $request->input('message')
            ]);

        return Response::noContent();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function answer(Request $request): \Illuminate\Http\Response
    {
        $question = Question::query()
            ->find($request->input('question_id'));

        $question->update([
            'has_answered' => true
        ]);

        Question::query()
            ->create([
                'user_id' => Auth::user()->getAuthIdentifier(),
                'target_id' => $question->user->id,
                'list_id' => $question->list_id,
                'question_id' => $question->id,
                'message' => $request->input('message'),
                'type' => 'answer'
            ]);

        return Response::noContent();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showAnswer(Request $request): \Illuminate\Http\Response
    {
        Question::query()
            ->where('id', $request->input('question_id'))
            ->update([
                'has_answered' => true
            ]);

        return Response::noContent();
    }
}
