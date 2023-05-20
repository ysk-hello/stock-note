<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Reader\Xls as XlsReader;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('company');
    }

    public function uploadFile(Request $request)
    {
        try {
            $file = $request->file('file');

            if(isset($file)){
                $reader = new XlsReader();
                $spreadsheet = $reader->load($file->path());
                $sheet = $spreadsheet->getActiveSheet();
                
                DB::transaction(function () use ($sheet) {
                    //$data = [];
                    foreach ($sheet->getRowIterator() as $row) {
                        if ($row->getRowIndex() === 1) {
                            continue;
                        }
            
                        $code = $sheet->getCell('B' . $row->getRowIndex())->getValue();
                        $name = $sheet->getCell('C' . $row->getRowIndex())->getValue();
                        // array_push($data,
                        //     [
                        //         'code' => $code,
                        //         'name' => $name
                        //     ]
                        // );
            
                        Company::updateOrCreate(
                            ['code' => $code],
                            ['name' => $name]
                        );
                    }
                });
            }
        } catch(Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

    public function getCompanies(Request $request)
    {
        logger("get data");
        return Company::orderBy('code', 'asc')->get();
    }

    public function searchCompanies(Request $request) {
        $keyword = '%' . trim($request['keyword']) . '%';
        logger($keyword);

        $companies = Company::where('code', 'like', $keyword)->orWhere('name', 'like', $keyword)
            ->leftJoin('favorites', 'code', '=', 'company_code')
            ->select('code', 'name', 'user_id')
            ->orderBy('code', 'asc')
            ->paginate(50);
        
        logger($companies);

        return $companies;
    }

    public function getName(Request $request)
    {
        return Company::where('code', '=', $request['code'])->first();
    }
}
