<?php

namespace App\Http\Controllers;

use App\Models\CompanyDiary;
use Illuminate\Http\Request;

class CompanyDiaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $ymd = $request['ymd'];
        $code = $request['code'];

        return view('companydiary', ['selected_date' => $ymd, 'company_code' => $code]);
    }

    public function getCompanyDiary(Request $request)
    {
        logger($request);

        $diary = CompanyDiary::where(['company_code' => $request['company_code'], 
            'user_id' => auth()->id(), 'date' => $request['date']])->first();

        logger($diary);

        return $diary;
    }

    public function getCompanyDiaries(Request $request)
    {
        $diaries = CompanyDiary::where(['company_code' => $request['company_code'], 
            'user_id' => auth()->id()])->get();

        return $diaries;
    }

    public function saveCompanyDiary(Request $request)
    {
        logger($request['date']);

        $diary = CompanyDiary::where(['company_code' => $request['company_code'], 
            'user_id' => auth()->id(), 'date' => $request['date']])->first();

        if(!isset($diary)){
            $diary = new CompanyDiary;
        }

        $diary->company_code = $request['company_code'];
        $diary->date = $request['date'];
        $diary->text = $request['text'];
        $diary->user_id = auth()->id();
        $diary->save();
    }

    public function deleteCompanyDiary(Request $request)
    {
        $diary = CompanyDiary::where(['company_code' => $request['company_code'], 
            'user_id' => auth()->id(), 'date' => $request['date']])->first();

        if(isset($diary)){
            $diary->delete();
        }
    }
}
