<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        return view('favorite');
    }

    public function getFavorites()
    {
        $favorites = Favorite::where('user_id', auth()->id())->join('companies', 'company_code', '=', 'code')
            ->select('code', 'name')->get();

        return $favorites;
    }

    public function checkState(Request $request)
    {
        $favorite = Favorite::where('user_id', auth()->id())->where('company_code', $request['code'])->first();

        if(isset($favorite)){
            return ['state' => true];
        }
        else{
            return ['state' => false];
        }
    }

    public function toggleState(Request $request)
    {
        // 複合主キーのエラー: サロゲートキーに変更して解決
        // https://www.threestarsoftware.co.jp/laravel/laravel%E3%81%A7%E8%A4%87%E5%90%88%E3%82%AD%E3%83%BC%E3%81%AB%E5%AF%BE%E5%BF%9C%E3%81%99%E3%82%8B%E6%96%B9%E6%B3%95/
        // https://stackoverflow.com/questions/73053454/column-not-found-1054-unknown-column-0-in-where-clause-sql-select-house
        $favorite = Favorite::where(['user_id' => auth()->id(), 'company_code' => $request['code']])->first();

        if(isset($favorite)){
            // 削除
            logger('delete');

            $favorite->delete();

            return ['state' => false];
        }
        else{
            // 追加
            logger('add');

            $favorite = new Favorite;
            $favorite->company_code = $request['code'];
            $favorite->user_id = auth()->id();
            $favorite->save();

            return ['state' => true];
        }
    }
}
