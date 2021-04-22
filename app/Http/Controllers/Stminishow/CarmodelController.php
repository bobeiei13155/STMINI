<?php

namespace App\Http\Controllers\Stminishow;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Carmodel;
use App\gen;
use Illuminate\Support\Facades\DB;

class CarmodelController extends Controller
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
                $carmodels = Carmodel::where('Status', '=', 0)->paginate(5);
                $count = Carmodel::where('Status', '=', 0)->count();
                return view('Stminishow.CarmodelForm', compact("carmodels"))->with('gens', gen::all())->with('count', $count);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }

    public function searchCMD(Request $request)
    {
        if (session()->has('login')) {
            if (session()->has('loginpermission3')) {
                $searchCMP = $request->searchCMD;
                $carmodels = DB::table('carmodels')
                    ->join('gens', 'carmodels.Gen_Id', "LIKE", 'gens.Id_Gen')
                    ->select('carmodels.Id_Carmodel', 'carmodels.Gen_Id', 'carmodels.Name_Carmodel', 'gens.Name_Gen', 'gens.Id_Gen', 'carmodels.Status')
                    ->where('Id_Carmodel', "LIKE", "%{$searchCMP}%")
                    ->orwhere('Name_Carmodel', "LIKE", "%{$searchCMP}%")
                    ->orwhere('Name_Gen', "LIKE", "%{$searchCMP}%")->paginate(5);
                $count = Carmodel::where('Status', '=', 0)->count();
                return view("Stminishow.SearchCarmodelForm")->with("carmodels", $carmodels)->with('gens', gen::all())->with('count', $count);
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
        // dd($request);
        $request->validate([
            'Name_Carmodel' => 'required|unique:Carmodels',
            'Gen_Id' => 'required'
        ]);

        $GenId = DB::table('carmodels')->max('Id_Carmodel');

        $GenId_CMD = substr($GenId, 11, 14) + 1;

        if ($GenId_CMD < 10) {
            $Id_Carmodel = "CMD" . "-" . date('Y') . date('m') . "-" . "00" . $GenId_CMD;
        } elseif ($GenId_CMD >= 10 && $GenId_CMD < 100) {
            $Id_Carmodel = "CMD" . "-" . date('Y') . date('m') . "-" . "0" . $GenId_CMD;
        } elseif ($GenId_CMD >= 100) {
            $Id_Carmodel = "CMD" . "-" . date('Y') . date('m') . "-" . $GenId_CMD;
        }



        $Carmodel = new Carmodel;
        $Carmodel->Id_Carmodel = $Id_Carmodel;
        $Carmodel->Name_Carmodel = $request->Name_Carmodel;
        $Carmodel->Gen_Id = $request->Gen_Id;
        $Carmodel->save();
        return redirect('/Stminishow/createCarmodel');
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
    public function edit($Id_Carmodel)
    {
        if (session()->has('login')) {
            if (session()->has('loginpermission3')) {
                $carmodel = carmodel::find($Id_Carmodel);

                return view('Stminishow.EditCarmodelForm', ['carmodel' => $carmodel])->with('gens', gen::all());
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
    public function update(Request $request, $Id_Carmodel)
    {
        $request->validate([
            'Name_Carmodel' => 'required',
            'Gen_Id' => 'required'
        ]);
        // dd($request->Gen_Id);
        $carmodels = carmodel::find($Id_Carmodel);
        $carmodels->Name_Carmodel = $request->Name_Carmodel;
        $carmodels->Gen_Id = $request->Gen_Id;
        $carmodels->save();
        return redirect('/Stminishow/createCarmodel');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($Id_Carmodel)
    {

        if (session()->has('login')) {
            if (session()->has('loginpermission3')) {
                $carmodel = carmodel::find($Id_Carmodel);
                $carmodel->Status = 1;
                $carmodel->save();
                return redirect('/Stminishow/createCarmodel');
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }
}
