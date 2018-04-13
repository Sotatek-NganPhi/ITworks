<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\AppBaseController;
use App\Models\SearchCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConditionController extends AppBaseController
{
    public function showListConditionPage()
    {
        return view('app.member.conditions');
    }

    public function registerCondition(Request $request)
    {
        SearchCondition::create([
            'user_id' => Auth::user()->id,
            'employment_mode_id' => $request->input("employment_mode_id"),
            'category_id' => $request->input("category_id"),
            'prefecture_id' => $request->input("prefecture_id"),
            'ward_id' => $request->input("ward_id"),
            'route_id' => $request->input("route_id"),
            'station_id' => $request->input("station_id"),
            'free_word' => $request->input("free_word"),
            'key_region' => $request->input("key_region"),
            'merits' => $request->input("merits"),
        ]);
        return redirect()->route('member_show_register_condition');
    }

    public function getListCondition()
    {
        $user = Auth::user();
        $searchConditions = SearchCondition::where('user_id', $user->id)->get();
        foreach ($searchConditions as $searchCondition) {
            $params = collect($searchCondition)->except(['id', 'user_id', 'created_at', 'updated_at', 'key_region']);
            $searchCondition['url'] = url($searchCondition->key_region . '/job?' . http_build_query($params->toArray()));
        }

        return $this->sendResponse($searchConditions, 'Search condition retrieved successfully');

    }

    public function removeCondition($id)
    {
        $user = Auth::user();
        SearchCondition::where('id', $id)
            ->where('user_id', $user->id)->delete();

        return $this->sendResponse(null, 'Search condition deleted successfully');
    }
}
