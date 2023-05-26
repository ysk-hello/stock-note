<?php

namespace App\Http\Controllers;

use App\Models\Diary;
use App\Models\CompanyDiary;
use Illuminate\Http\Request;

class ReportConroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('report');
    }

    public function reportDiaries(Request $request) 
    {
        $diaries = Diary::where(['user_id' => auth()->id()])
            ->where('date', '>=', $request['startDate'])
            ->where('date', '<=', $request['endDate'])
            ->select('date', 'text')
            ->orderBy('date', 'asc')
            ->get();
        $csvHeader = ['date', 'text'];
        $csvData = $diaries->toArray();

        $callback = function() use ($csvHeader, $csvData) {
            $handle = fopen('php://output', 'w');

            mb_convert_variables('SJIS-win', 'UTF-8', $csvHeader);
            fputcsv($handle, $csvHeader);

            foreach($csvData as $row) {
                mb_convert_variables('SJIS-win', 'UTF-8', $row);
                fputcsv($handle, $row);
            }

            fclose($handle);
        };
        
        return response()->stream(
            $callback,
            200, 
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="diary.csv"'
            ]);
    }

    public function reportCompanyDiaries(Request $request) 
    {
        $diaries = CompanyDiary::where(['user_id' => auth()->id()])
            ->where('date', '>=', $request['startDate'])
            ->where('date', '<=', $request['endDate'])
            ->leftJoin('companies', 'company_code', 'code')
            ->select('company_diaries.company_code', 'companies.name', 'company_diaries.date', 'company_diaries.text')
            ->orderBy('company_diaries.company_code', 'asc')
            ->orderBy('company_diaries.date', 'asc')
            ->get();
        $csvHeader = ['code', 'name', 'date', 'text'];
        $csvData = $diaries->toArray();

        $callback = function() use ($csvHeader, $csvData) {
            $handle = fopen('php://output', 'w');

            mb_convert_variables('SJIS-win', 'UTF-8', $csvHeader);
            fputcsv($handle, $csvHeader);

            foreach($csvData as $row) {
                mb_convert_variables('SJIS-win', 'UTF-8', $row);
                fputcsv($handle, $row);
            }

            fclose($handle);
        };
        
        return response()->stream(
            $callback,
            200, 
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="companydiary.csv"'
            ]);
    }
}
