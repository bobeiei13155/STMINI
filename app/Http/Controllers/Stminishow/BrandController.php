<?php

namespace App\Http\Controllers\Stminishow;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\brand;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (session()->has('login')) {
            if (session()->has('loginpermission3')) {
                $brands = brand::where('Status', '=', 0)->paginate(5);
                $count = brand::where('Status', '=', 0)->count();
                return view('Stminishow.BrandForm', compact("brands"))->with('count', $count);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function searchBND(Request $request)
    {

        if (session()->has('login')) {
            if (session()->has('loginpermission3')) {
                $searchBND = $request->searchBND;
                $brands = DB::table('brands')
                    ->where('Id_Brand', "LIKE", "%{$searchBND}%")->select('Id_Brand', 'Name_Brand', 'Status')->where('Status', '=', 0)
                    ->orwhere('Name_Brand', "LIKE", "%{$searchBND}%")->paginate(5);
                $count = brand::where('Status', '=', 0)->count();
                return view("Stminishow.SearchBrandForm")->with("brands", $brands)->with('count', $count);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $GenId = DB::table('brands')->max('Id_Brand');

        if (is_null($GenId)) {
            $Id_Brand = "BND" . "-" . date('Y') . date('m') . "-" . "000";
        } else {
            $GenId_BND = substr($GenId, 11, 14) + 1;

            if ($GenId_BND < 10) {
                $Id_Brand = "BND" . "-" . date('Y') . date('m') . "-" . "00" . $GenId_BND;
            } elseif ($GenId_BND >= 10 && $GenId_BND < 100) {
                $Id_Brand = "BND" . "-" . date('Y') . date('m') . "-" . "0" . $GenId_BND;
            } elseif ($GenId_BND >= 100) {
                $Id_Brand = "BND" . "-" . date('Y') . date('m') . "-" . $GenId_BND;
            }
        }
        // dd($Id_Color);
        $request->validate([
            'Name_Brand' => 'required|unique:brands'
        ]);
        $brand = new brand;
        $brand->Id_Brand = $Id_Brand;
        $brand->Name_Brand = $request->Name_Brand;
        $brand->save();
        return redirect('/Stminishow/createBrand');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($Id_Brand)
    {
        if (session()->has('login')) {
            if (session()->has('loginpermission3')) {
                $brand = brand::find($Id_Brand);

                return view('Stminishow.EditBrandForm', ['brands' => $brand]);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Id_Brand)
    {
        $request->validate([
            'Name_Brand' => 'required|unique:brands'
        ]);

        $brand = brand::find($Id_Brand);
        $brand->Name_Brand = $request->Name_Brand;
        $brand->save();
        return redirect('/Stminishow/createBrand');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($Id_Brand)
    {
        if (session()->has('login')) {
            if (session()->has('loginpermission3')) {
                $brand =   brand::find($Id_Brand);
                $brand->Status = 1;
                $brand->save();
                return redirect('/Stminishow/createBrand');
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }
}
