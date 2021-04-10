<?php

namespace App\Http\Controllers\Stminishow;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Categorymember;
use Illuminate\Support\Facades\DB;

class CategorymemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (session()->has('login')) {
            if (session()->has('loginpermission5')) {

                $categorymembers = categorymember::where('Status', '=', 0)->paginate(5);
                $count = categorymember::where('Status', '=', 0)->count();
                return view('Stminishow.CategorymemberForm', compact("categorymembers"))->with('count', $count);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }


    public function searchCMB(Request $request)
    {
        if (session()->has('login')) {
            if (session()->has('loginpermission5')) {
                $searchCMB = $request->SearchCMB;
                $categorymembers = DB::table('categorymembers')
                    ->where('Id_Cmember', "LIKE", "%{$searchCMB}%")
                    ->orwhere('Name_Cmember', "LIKE", "%{$searchCMB}%")
                    ->orwhere('Discount_Cmember', "LIKE", "%{$searchCMB}%")->paginate(5);
                    $count = categorymember::where('Status', '=', 0)->count();
                return view("Stminishow.SearchCategorymemberForm")->with("categorymembers", $categorymembers)->with('count', $count);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $GenId = DB::table('categorymembers')->max('Id_Cmember');

        if (is_null($GenId)) {
            $Id_Cmember = "CMB" . "-" . date('Y') . date('m') . "-" . "000";
        } else {
            $GenId_CMB = substr($GenId, 11, 14) + 1;

            if ($GenId_CMB < 10) {
                $Id_Cmember = "CMB" . "-" . date('Y') . date('m') . "-" . "00" . $GenId_CMB;
            } elseif ($GenId_CMB >= 10 && $GenId_CMB < 100) {
                $Id_Cmember = "CMB" . "-" . date('Y') . date('m') . "-" . "0" . $GenId_CMB;
            } elseif ($GenId_CMB >= 100) {
                $Id_Cmember = "CMB" . "-" . date('Y') . date('m') . "-" . $GenId_CMB;
            }
        }
        // dd($Id_Color);
        $request->validate([
            'Name_Cmember' => 'required|unique:categorymembers',
            'Discount_Cmember' => 'required|unique:categorymembers'

        ]);
        $categorymember = new categorymember;
        $categorymember->Id_Cmember = $Id_Cmember;
        $categorymember->Name_Cmember = $request->Name_Cmember;
        $categorymember->Discount_Cmember = $request->Discount_Cmember;
        $categorymember->save();
        return redirect('/Stminishow/createCategorymember');
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
    public function edit($Id_Cmember)
    {

        if (session()->has('login')) {
            if (session()->has('loginpermission5')) {
                $categorymembers = categorymember::find($Id_Cmember);

                return view('Stminishow.EditCategorymemberForm', ['categorymembers' => $categorymembers]);
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
    public function update(Request $request, $Id_Cmember)
    {
        $request->validate([
            'Name_Cmember' => 'required',
            'Discount_Cmember' => 'required'
        ]);
        // dd($request->Gen_Id);
        $categorymembers = categorymember::find($Id_Cmember);
        $categorymembers->Name_Cmember = $request->Name_Cmember;
        $categorymembers->Discount_Cmember = $request->Discount_Cmember;
        $categorymembers->save();

        return redirect('/Stminishow/createCategorymember');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($Id_Cmember)
    {
        if (session()->has('login')) {
            if (session()->has('loginpermission5')) {
                $categorymember = categorymember::find($Id_Cmember);
                $categorymember->Status = 1;
                $categorymember->save();
                return redirect('/Stminishow/createCategorymember');
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }
}
