<?php

namespace App\Http\Controllers\Stminishow;

use App\Telptn;
use App\Partner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\costs;
use Illuminate\Support\Facades\Session;
class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function searchPTN(Request $request)
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission4')) {
                $count = partner::where('Status', '=', 0)->count();
                
                $searchPTN = $request->searchPTN;

                $partners = DB::table('partners')

                    ->Join('telptns', 'partners.Id_Partner', '=', 'telptns.Id_Partner')
                    ->select('partners.Id_Partner','partners.Name_Partner','telptns.Tel_PTN','partners.Status')
                    ->where('partners.Id_Partner', "LIKE", "%{$searchPTN}%")
                    ->orwhere('partners.Name_Partner', "LIKE", "%{$searchPTN}%")
                    ->orwhere('telptns.Tel_PTN', "LIKE", "%{$searchPTN}%")
                    ->groupBy('partners.Id_Partner','partners.Name_Partner','telptns.Tel_PTN','partners.Status')->orderBy('partners.Id_Partner', 'DESC')
                    ->paginate(5);

            
             
    
                 return view("Stminishow.SearchPartnerForm")->with("partners", $partners)->with('count', $count);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }



    public function ShowPTN()
    {
        $partners = DB::table('partners')->orderBy('Id_Partner', 'DESC')->paginate(5);
    
        $telptns = Telptn::all();
        $count = partner::where('Status', '=', 0)->count();
        return view('Stminishow.ShowPartnerForm')->with('partners', $partners)->with('telptns', $telptns)->with('count', $count);
    }
    public function index()
    {
        $list = DB::table('province')->orderBy('PROVINCE_NAME', 'asc')->get();
        $am = DB::table('amphur')->orderBy('AMPHUR_NAME', 'asc')->get();

       
        $GenId = DB::table('partners')->max('Id_Partner');
        if (is_null($GenId)) {
            $Id_Partner = "PTN" . "-" . date('Y') . date('m') . "-" . "000";
        } else {

            $GenId_PTN = substr($GenId, 11, 14) + 1;
            if ($GenId_PTN < 10) {
                $Id_Partner = "PTN" . "-" . date('Y') . date('m') . "-" . "00" . $GenId_PTN;
            } elseif ($GenId_PTN >= 10 && $GenId_PTN < 100) {
                $Id_Partner = "PTN" . "-" . date('Y') . date('m') . "-" . "0" . $GenId_PTN;
            } elseif ($GenId_PTN >= 100) {
                $Id_Partner = "PTN" . "-" . date('Y') . date('m') . "-" . $GenId_PTN;
            }
        }

        $Id_Partner = json_decode(json_encode($Id_Partner), true);

       
        Session::put('Id_Partner', $Id_Partner);



        return view('Stminishow.PartnerForm')->with('list', $list)->with('am', $am)->with('products', product::all());
    }
    public function f_amphures(Request $request)
    {
        $id = $request->get('select');
        $result = array();
        $query = DB::table('province')
            ->join('amphur', 'province.PROVINCE_ID', '=', 'amphur.PROVINCE_ID')
            ->select('amphur.AMPHUR_NAME', 'amphur.AMPHUR_ID')
            ->where('province.PROVINCE_ID', $id)
            ->groupBy('amphur.AMPHUR_NAME', 'amphur.AMPHUR_ID')
            ->get();
        $output = '<option value="">เลือกอำเภอของท่าน</option>';
        foreach ($query as $row) {
            $output .= '<option value="' . $row->AMPHUR_ID . '">' . $row->AMPHUR_NAME . '</option>';
        }
        echo $output;
    }

    public function f_districts(Request $request)
    {
        $id = $request->get('select');
        $result = array();
        $query = DB::table('amphur')
            ->join('district', 'amphur.AMPHUR_ID', '=', 'district.AMPHUR_ID')
            ->select('district.DISTRICT_NAME', 'district.DISTRICT_ID')
            ->where('amphur.AMPHUR_ID', $id)
            ->groupBy('district.DISTRICT_NAME', 'district.DISTRICT_ID')
            ->get();
        $output = '<option value="">เลือกตำบลของท่าน</option>';
        foreach ($query as $row) {
            $output .= '<option value="' . $row->DISTRICT_ID . '">' . $row->DISTRICT_NAME . '</option>';
        }
        echo $output;
    }

    public function f_postcode(Request $request)
    {
        $id = $request->get('select');
        $result = array();
        $query = DB::table('district')
            ->select('POSTCODE')
            ->where('district.DISTRICT_ID', $id)
            ->get();
        $output = '<option value="">เลือกรหัสไปรษณีย์ของท่าน</option>';
        foreach ($query as $row) {
            $output .= '<option value="' . $row->POSTCODE . '" selected>' . $row->POSTCODE . '</option>';
        }
        echo $output;
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

        $request->validate([

            'Name_Partner' => 'required|unique:partners',
            'Province_Id' => 'required',
            'District_Id' => 'required',
            'Postcode_Id' => 'required',
            'Subdistrict_Id' => 'required',
            'Tel_PTN.*' => 'required',


        ]);



        $GenId = DB::table('partners')->max('Id_Partner');
        $GenId_PTN = substr($GenId, 11, 14) + 1;
        if ($GenId_PTN < 10) {
            $Id_Partner = "PTN" . "-" . date('Y') . date('m') . "-" . "00" . $GenId_PTN;
        } elseif ($GenId_PTN >= 10 && $GenId_PTN < 100) {
            $Id_Partner = "PTN" . "-" . date('Y') . date('m') . "-" . "0" . $GenId_PTN;
        } elseif ($GenId_PTN >= 100) {
            $Id_Partner = "PTN" . "-" . date('Y') . date('m') . "-" . $GenId_PTN;
        }
        $partner = new Partner;
        $partner->Name_Partner = $request->Name_Partner;
        $partner->Id_Partner = $Id_Partner;
        $partner->Address_Partner = $request->Address_Partner;
        $partner->Province_Id = $request->Province_Id;
        $partner->District_Id = $request->District_Id;
        $partner->Postcode_Id = $request->Postcode_Id;
        $partner->Subdistrict_Id = $request->Subdistrict_Id;
        $partner->save();

        foreach ($request['Tel_PTN'] as $item => $value) {
            $request2 = array(
                'Id_Partner' => $Id_Partner,
                'Tel_PTN' => $request['Tel_PTN'][$item]
            );
            Telptn::create($request2);
        };

        foreach ($request['cost'] as $item => $value) {
            $request3 = array(
                'Id_Partner' => $Id_Partner,
                'Id_Product' => $request['Id_Product'][$item],
                'Cost' => $request['cost'][$item]
            );
            costs::create($request3);
        };

        return redirect('/Stminishow/showPartner');
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
    public function edit($Id_Partner)
    {

        $partner = Partner::find($Id_Partner);

        $list = DB::table('province')->orderBy('PROVINCE_NAME', 'asc')->get();
        $amphur = DB::table('amphur')->orderBy('AMPHUR_NAME', 'asc')->get();
        $subdistrict = DB::table('district')->orderBy('DISTRICT_NAME', 'asc')->get();
        $telptns = DB::table('telptns')->where('Id_Partner', $Id_Partner)->get();
        $costs = DB::table('costs')
            ->join('products', 'products.Id_Product', '=', 'costs.Id_Product')
            ->select('products.Name_Product', 'costs.Cost', 'products.Id_Product')
            ->where('Id_Partner', $Id_Partner)->where('costs.Status','=','0')->get();

        // echo"<pre>";
        // print_r($telemps);
        // echo"</pre>";
        return view('Stminishow.EditPartnerForm', ['partners' => $partner])->with('costs', $costs)->with('products', product::all())->with('telptns', $telptns)->with('subdistrict', $subdistrict)->with('amphur', $amphur)->with('list', $list);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Id_Partner)
    {

        $request->validate([
            'Name_Partner' => 'required',
            'Province_Id' => 'required',
            'District_Id' => 'required',
            'Postcode_Id' => 'required',
            'Subdistrict_Id' => 'required',
            'Tel_PTN.*' => 'required',
        ]);

        $Tel_PTN = DB::table('telptns')
            ->select('telptns.Id_Partner')
            ->where('telptns.Id_Partner', '=', $Id_Partner)->get();

        $costs = DB::table('costs')
            ->select('Id_Partner')
            ->where('Id_Partner', '=', $Id_Partner)->get();

        $datacost =    json_decode(json_encode($costs), true);

        $data = json_decode(json_encode($Tel_PTN), true);

        $partner = Partner::find($Id_Partner);
        $partner->Name_Partner = $request->Name_Partner;
        $partner->Address_Partner = $request->Address_Partner;
        $partner->Province_Id = $request->Province_Id;
        $partner->District_Id = $request->District_Id;
        $partner->Postcode_Id = $request->Postcode_Id;
        $partner->Subdistrict_Id = $request->Subdistrict_Id;
        $partner->save();

        if ($datacost != []) {
           
            foreach ($request['cost'] as $item => $value) {
                $request3 = array(
                    'Id_Partner' => $Id_Partner,
                    'Id_Product' => $request['Id_Product'][$item],
                    'Cost' => $request['cost'][$item]
                );
                DB::statement("UPDATE `stminidb`.`costs` SET `Status` = '1' WHERE `Id_Partner` = '".$Id_Partner."' AND `Id_Product` = '".$request['Id_Product'][$item]."' ");
                costs::create($request3);
            
            }
        } else {
            foreach ($request['cost'] as $item => $value) {
                $request3 = array(
                    'Id_Partner' => $Id_Partner,
                    'Id_Product' => $request['Id_Product'][$item],
                    'Cost' => $request['cost'][$item]
                );
                costs::create($request3);
            }
        }
        if ($data != []) {
            Telptn::destroy([$data]);
            foreach ($request['Tel_PTN'] as $item => $value) {
                $request2 = array(
                    'Id_Partner' => $Id_Partner,
                    'Tel_PTN' => $request['Tel_PTN'][$item]
                );
                Telptn::create($request2);
            }
        } else {
            foreach ($request['Tel_PTN'] as $item => $value) {
                $request2 = array(
                    'Id_Partner' => $Id_Partner,
                    'Tel_PTN' => $request['Tel_PTN'][$item]
                );
                Telptn::create($request2);
            }
        }

        return redirect('/Stminishow/showPartner');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($Id_Partner)
    {

        // dd($Id_Partner);
        Partner::destroy($Id_Partner);
        return redirect('/Stminishow/showPartner');
    }
}
