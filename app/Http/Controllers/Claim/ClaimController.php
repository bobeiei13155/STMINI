<?php

namespace App\Http\Controllers\Claim;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Telmem;

class ClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ShowClaim()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission15')) {

                $claims = DB::select(DB::raw("SELECT claims.Id_Claim ,IFNULL(FName_Member,'ลูกค้าทั่วไป') as FName_Member ,FName_Emp ,Claim_Date FROM claims 
                LEFT JOIN members on members.Id_Member = claims.Id_Mem
                JOIn employees on employees.Id_Emp = claims.Id_Emp
                JOIN claim_lists on claim_lists.Id_Claim = claims.Id_Claim"));

                return view("Claim.ShowClaimForm")->with('claims', $claims);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }


    public function Detail_Claim(Request $request)
    {
        $Id_Claim = $request->Id_Claim;
        // dd($Id_Claim);


        $claims = DB::select(DB::raw("SELECT FName_Emp,IFNULL(FName_Member,'ลูกค้าทั่วไป') as FName_Member ,Claim_Date FROM claims JOIN employees on employees.Id_Emp = claims.Id_Emp
        LEFT JOIN members on members.Id_Member = claims.Id_Mem 
        WHERE claims.Id_Claim ='" . $Id_Claim . "'
        "));
        // // dd($sells);


        $claim_lists = DB::select(DB::raw(" SELECT Name_Product , claim_lists.Amount_Claim FROM claim_lists JOIN lot_lists on lot_lists.Id_Lot  = claim_lists.Id_Lot
        JOIN products on lot_lists.Id_Product = products.Id_Product
        WHERE claim_lists.Id_Claim ='" . $Id_Claim . "'
        "));




        $output = '';



        foreach ($claims as  $row) {
            $output .= ' <div class="row ">';
            $output .= ' <div class="input-group col-sm-6 ">';
            $output .= ' <div class="input-group-prepend"> ';
            $output .= '  <span class="input-group-text a1" id="inputGroup-sizing-default" style="width:120px">รหัสใบเคลม :</span> </div>';
            $output .= '  <input type="text" class="form-control" name="Ip_Id_Promotion_Product" id="Ip_Id_Promotion_Product" value="' . $Id_Claim . '" style="background-color: #E8ECEE; border-radius: 0px 10px 10px 0px; " readonly>';
            $output .= '  </div>';
            $output .= ' <div class="input-group col-sm-6 ">';
            $output .= ' <div class="input-group-prepend"> ';
            $output .= '  <span class="input-group-text a1"  id="inputGroup-sizing-default" style="width:120px">วันที่เคลม :</span> </div>';
        
            $output .= '  <input type="text" class="form-control" name="Ip_Id_Promotion_Product" id="Ip_Id_Promotion_Product" value="' . $row->Claim_Date . '" style="background-color: #E8ECEE; border-radius: 0px 10px 10px 0px; " readonly>';
            $output .= '  </div>';
            $output .= '  </div>';
            $output .= '  <br>';
            $output .= ' <div class="row ">';
            $output .= ' <div class="input-group col-sm-6 ">';
            $output .= ' <div class="input-group-prepend"> ';
            $output .= '  <span class="input-group-text a1" id="inputGroup-sizing-default" style="width:120px">ชื่อพนักงาน :</span> </div>';
            $output .= '  <input type="text" class="form-control" name="Ip_Id_Promotion_Product" id="Ip_Id_Promotion_Product" value="' . $row->FName_Emp . '" style="background-color: #E8ECEE; border-radius: 0px 10px 10px 0px; " readonly>';
            $output .= '  </div>';
            $output .= ' <div class="input-group col-sm-6 ">';
            $output .= ' <div class="input-group-prepend"> ';
            $output .= '  <span class="input-group-text a1" id="inputGroup-sizing-default" style="width:120px">ชื่อลูกค้า :</span> </div>';
            $output .= '  <input type="text" class="form-control" name="Ip_Id_Promotion_Product" id="Ip_Id_Promotion_Product" value="' . $row->FName_Member . '" style="background-color: #E8ECEE; border-radius: 0px 10px 10px 0px; " readonly>';
            $output .= '  </div>';
            $output .= '  </div>';
            $output .= '  <br>';
        }

        $output .= ' <h2>รายการสินค้า</h2>';
        $output .= ' <table class="table table-striped table-hover  text-center ">';
        $output .= ' <thead>';
        $output .= ' <tr>';
        $output .= ' <th>ชื่อสินค้า</th>';
        $output .= ' <th>จำนวนสินค้า</th>';
        $output .= '  </tr> ';
        $output .= ' </thead> ';
        $output .= '  <tbody>';



        foreach ($claim_lists as  $claim_list) {
            $output .= '<tr>';
            $output .= '<td>' . $claim_list->Name_Product . '</td>';
            $output .= '<td>' . $claim_list->Amount_Claim . '</td>';
            $output .= '</tr>';
        }
        $output .= '  </tbody>';
        $output .= ' </table> ';

        echo $output;
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createClaim()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission12')) {


                $sells = DB::table('sells')->select('sells.Id_Sell', 'FName_Emp', 'FName_Member', 'members.FName_Member')->join('employees', 'employees.Id_Emp', '=', 'sells.Id_Emp')
                    ->leftJoin('members', 'members.Id_Member', '=', 'sells.Id_Member')->where('sells.Status', '=', 0)->get();



                $members = DB::table('members')
                    ->join('categorymembers', 'members.Cmember_Id', '=', 'categorymembers.Id_Cmember')
                    // ->join('telmems','members.Id_Member','=','telmems.Id_Member')
                    ->select('Id_Member', 'FName_Member', 'LName_Member', 'Name_Cmember', 'Discount_Cmember',)
                    ->get();

                $telmems = Telmem::all();

                // $products = DB::table('products')->where('Status', '=', '0')->get();
                $brands = DB::table('brands')->where('Status', '=', '0')->get();
                $categories = DB::table('categories')->get();
                $gens = DB::table('gens')->where('Status', '=', '0')->get();
                $payments = DB::table('payments')->where('Status', '=', '0')->get();



                // ->whereBetween('',[,])
                // $products = DB::table('lot_lists')->RightJoin('products', 'products.Id_Product', '=', 'lot_lists.Id_Product')->where('products.Status', '=', '0')
                //     ->get();
                // $lot_products = DB::table('lot_lists')->RightJoin('products', 'products.Id_Product', '=', 'lot_lists.Id_Product')->where('products.Status', '=', '0')
                //     ->get();
                $products = DB::table('lot_lists')->Join('products', 'products.Id_Product', '=', 'lot_lists.Id_Product')->where('products.Status', '=', '0')
                    ->get();
                $lot_products = DB::table('lot_lists')->Join('products', 'products.Id_Product', '=', 'lot_lists.Id_Product')->where('products.Status', '=', '0')
                    ->get();
                // dd($lot_products);
                $date = date('Y-m-d');




                // dd($promotionpays);
                return view('Claim.ClaimForm')
                    ->with('sells', $sells)
                    ->with('members', $members)

                    ->with('telmems', $telmems)
                    ->with('lot_products', $lot_products)
                    ->with('products', $products)
                    ->with('brands', $brands)
                    ->with('gens', $gens)
                    ->with('payments', $payments)
                    ->with('categories', $categories);
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
    public function select_Id_Sell(Request $request)
    {
        $Id_Sell =  $request->Id_Sell;
        $date = date('Y-m-d');
        $sells = DB::select(DB::raw("SELECT Name_Product,Amount_Sell,End_Insurance,sell_lists.Id_Product  FROM sell_lists
        JOIN lot_lists  on lot_lists.Id_Lot = sell_lists.Id_Lot  and lot_lists.No_Lot = sell_lists.No_Lot
        JOIN products  on products.Id_Product = sell_lists.Id_Product WHERE sell_lists.Id_Sell = '" . $Id_Sell . "' AND '" . $date . "' <= End_Insurance
        "));


        $output = "";

        foreach ($sells as $row) {
            $output .= '<tr id="' . $Id_Sell .  '">';
            $output .= '<td width="9%"><input type="text" class="form-control text-center noHover"  value="' . $row->Name_Product .  '" readonly>
            <input type="hidden" class="form-control text-center noHover"  value="' . $row->Id_Product .  '" name="Id_Product_Lot[]" > </td>';
            $output .= '   ';
            $output .= ' <td width="2%">   <input type="text" class="form-control text-center noHover "  value="' . $row->Amount_Sell .  ' "readonly></td>';
            // $output .= ' <td>  <input type="hidden" class="form-control text-center noHover"  value="' . $row->Id_Product .  '" name="Id_Product[]" ></td>';
            $output .= '<td width="6%"><input type="text" class="form-control text-center" value="' . $row->End_Insurance .  '" " name="End_Insurance[]"readonly></td>';
            $output .= '<td width="2%"><button type="button" class="btn btn-warning select_Id_Product " data-toggle="modal" data-target="#myModal_Product_Lot" name="select_Id_Product" id="' . $row->Id_Product .  '" " style="border-radius: 5px;  "> <i class="fas fa-tools"></i></button></td>';
        }

        $output .= '</tr>';
        echo  $output;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function select_Id_Product(Request $request)
    {
        $Id_Product =  $request->Id_Product;
        $Id_Sell =  $request->Id_Sell;

        $Lot_lists = DB::select(DB::raw("SELECT products.Name_Product,Id_Lot,No_Lot,products.Price,lot_lists.Id_Product,lot_lists.Amount_Lot FROM lot_lists
        JOIN products on products.Id_Product = lot_lists.Id_Product 
        WHERE products.`Status` = 0 and lot_lists.Id_Product = '" . $Id_Product . "'
        "));

        $output = "";

        foreach ($Lot_lists as $row) {
            $output .= '<tr id="' . $Id_Sell .  '">';
            $output .= '<td width="9%"><input type="text" class="form-control text-center noHover"  value="' . $row->Name_Product .  '" readonly>
            <input type="hidden" class="form-control text-center noHover"  value="' . $row->Id_Product .  '" name="Id_Product_List[]" >  </td>';
            $output .= ' <td width="6%">   <input type="text" class="form-control text-center noHover"  value="' . $row->Price .  ' "readonly></td>';
            $output .= ' <td width="6%">   <input type="text" class="form-control text-center noHover Amount_Claim"  value="' . $row->Amount_Lot .  ' "readonly></td>';
            // $output .= ' <td>  <input type="hidden" class="form-control text-center noHover"  value="' . $row->Id_Product .  '" name="Id_Product[]" ></td>';
            $output .= '<td width="2%"><button type="button" class="btn select_Id_Product_Lot"  name="select_Id_Product_Lot" id="' . $Id_Product .  '" " style="background-color: #42A667;border-color:#42A667;border-radius: 5px;  "> <i class="fas fa-cart-arrow-down"></i></button>
            <input type="hidden" class="form-control text-center noHover Id_Lot_List"  value="' . $row->Id_Lot .  '" name="Id_Lot_List[]" ></td>';
        }

        $output .= '</tr>';
        echo  $output;

        // dd($Lot_lists);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function select_Id_Product_Show(Request $request)
    {

        $Id_Product =  $request->Id_Product;
        $Id_Lot =  $request->Id_Lot;
        $Id_Sell = $request->Id_Sell;
        $Lot_lists = DB::select(DB::raw("SELECT * FROM lot_lists
        JOIN products on products.Id_Product = lot_lists.Id_Product 
        JOIN categories on categories.Id_Category = products.Category_Id 
        JOIN brands on brands.Id_Brand = products.Brand_Id 
        		JOIN sell_lists on sell_lists.Id_Product = products.Id_Product 
        WHERE  lot_lists.Id_Product = '" . $Id_Product . "' and lot_lists.Id_Lot = '" . $Id_Lot . "'
        and sell_lists.Id_Sell = '" . $Id_Sell . "'
        "));
        // dd($Lot_lists);
        // $date = date('Y-m-d');
        $sells = DB::select(DB::raw("SELECT Amount_Sell FROM sell_lists
        JOIN lot_lists  on lot_lists.Id_Lot = sell_lists.Id_Lot  and lot_lists.No_Lot = sell_lists.No_Lot
        JOIN products  on products.Id_Product = sell_lists.Id_Product WHERE sell_lists.Id_Sell = '" . $Id_Sell . "' AND sell_lists.Id_Product  = '" . $Id_Product . "'  
        "));

        foreach ($sells as $row) {
            $Amount_Sell = $row->Amount_Sell;
        };



        $output = '';
        // <img src="asset(storage)/Products_image/'.$row->Img_Product.'", alt="" width="80px" height="80px">

        foreach ($Lot_lists as $row) {

            $output .= '<tr id="rowp' . $Id_Sell . '" >';
            $output .= '<td scope="row" width="6%"><img src="http://127.0.0.1:8000/storage/Products_image/' . $row->Img_Product . '" alt="" width="80px" height="90px"></td>';
            $output .= ' <td scope="row" width="9%" ><input type="text" class="form-control text-center noHover"  value="' . $row->Name_Product . '"  style="" disabled>';
            $Price = number_format($row->Price, 2);
            $output .= '  <input type="hidden" class="form-control text-center noHover Id_Product_Sell "  value="' . $row->Id_Product . '" name="Id_Product_Sell[]" >';
            // $output .= ' <input type="hidden" class="form-control text-center noHover No_Product"  value="' . $No_Product . '" name="No_Product">';
            $output .= ' <input type="hidden" class="form-control text-center noHover rowp "  value="' . $Id_Sell . '" name="rowp[]">';
            $output .= ' <input type="hidden" class="form-control text-center noHover Id_Lot_Product "  value="' . $Id_Lot . '" name="Id_Lot_Product[]">';
            $output .= ' <input type="hidden" class="form-control text-center noHover No_Lot_Product "  value="' . $row->No_Lot . '" name="No_Lot_Product[]">';
            $output .= ' <input type="hidden" class="form-control text-center noHover No_Sell_Product "  value="' . $row->No_Sell . '" name="No_Sell_Product[]">';
            $output .= '   </td>';
            $output .= ' <td scope="row" width="5%" ><input type="text" class="form-control text-center noHover"  value="' . $row->Name_Brand . '" name="Amount_Remain[]" readonly>';
            $output .= ' <input type="hidden" class="form-control text-center noHover Id_Brand"  value="' . $row->Id_Brand . '" name="Id_Brand[]">';
            $output .= ' </td>';
            $output .= ' <td scope="row" width="5%" >';

            $output .= '  <input type="text" class="form-control text-center noHover "  value="' . $Price . '" " readonly> ';
            $output .= ' <input type="hidden" class="form-control text-center noHover the_input_cost"  value="' . $row->Price . '" name="Price_Sell[]">';
            $output .= '  </td>';
            $output .= ' <td scope="row" width="5%" ><input type="number" class="form-control text-center noHover the_input_approve" name="Amount_Sell[]" value="1" min="1" max="' . $Amount_Sell . '" title= "กรุณาใส่ให้ตรง" required></td>';
            $output .= ' <td scope="row" width="5%" ><input type="text" class="form-control text-center noHover total_cost_s"  value="' . $Price . '" " readonly>
                        <input type="hidden" class="form-control text-center noHover  total_cost"  value="' . $row->Price . '" name="total_cost[]" >         ';
            $output .= ' </td> ';
            $output .= ' <td scope="row" width="5%" > <button type="button" class="btn btn-danger remove" id="" value="' . $row->Id_Product . '"  style="border-radius: 5px; width: 60px; "> <i class="fas fa-trash" style="margin-right: 5px;"></i>  </button></td>';

            // });

            $output .= ' </tr>';
        }

        echo $output;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storeClaim(Request $request)
    {
        // dd($request);
        $Id_Product_Sell = $request['Id_Product_Sell'];
        $rowp = $request['rowp'][0];
        $Id_Member = DB::table('sells')->select('Id_Member')->where('Id_Member', '=', $rowp)->first();
        if (empty($Id_Member)) {
            $Id_Member = Null;
        }
        // $Id_Sell = $

        $GenId = DB::table('claims')->max('Id_Claim');
        $GenId_Claim = substr($GenId, 11, 14) + 1;
        if (is_null($GenId)) {
            $Id_Claim = "CAM" . "-" . date('Y') . date('m') . "-" . "000";
        } else {

            if ($GenId_Claim < 10) {
                $Id_Claim = "CAM" . "-" . date('Y') . date('m') . "-" . "00" . $GenId_Claim;
            } elseif ($GenId_Claim >= 10 && $GenId_Claim < 100) {
                $Id_Claim = "CAM" . "-" . date('Y') . date('m') . "-" . "0" . $GenId_Claim;
            } elseif ($GenId_Claim >= 100) {
                $Id_Claim = "CAM" . "-" . date('Y') . date('m') . "-" . $GenId_Claim;
            }
        }
        $Id = session()->get('fname');
        $id_Emp = DB::table('employees')->select('Id_Emp')->where('FName_Emp', "=", "{$Id}")->get();
        $Id_Emp = $id_Emp[0]->Id_Emp;


        // $string = str_replace(',', '', $string);

        // dd($payment_con);
        $datetime = date('Y-m-d');
        // dd($datetime);
        $sql_in_claim  = array(
            'Id_Claim' => $Id_Claim,
            'Id_Mem' => $Id_Member,
            'Id_Emp' => $Id_Emp,
            'Claim_Date' => $datetime,
            'Id_Mem' => $Id_Member,
        );

        print_r($sql_in_claim);
        echo '<br>';
        DB::table('claims')->insert([$sql_in_claim]);



        $No_Claim = 0;
        foreach ($Id_Product_Sell as $item  => $value) {
            $No_Claim++;
            $claim_lists = array(
                'Id_Claim' => $Id_Claim,
                'No_Claim' => $No_Claim,
                'Id_Product' => $value,
                'Id_Lot' => $request['Id_Lot_Product'][$item],
                'No_Lot' => $request['No_Lot_Product'][$item],
                'Amount_Claim' => $request['Amount_Sell'][$item],
                'Id_Sell' => $request['rowp'][$item],
                'No_Sell' => $request['No_Sell_Product'][$item],
            );
            print_r($claim_lists);
            echo '<br>';

            DB::table('claim_lists')->insert([$claim_lists]);

            DB::statement("UPDATE lot_lists SET Amount_Lot = Amount_Lot - '" . $request['Amount_Sell'][$item] . "', Amount_Claim = Amount_Claim + '" . $request['Amount_Sell'][$item] . "'  WHERE Id_Lot = '" . $request['Id_Lot_Product'][$item] . "' 
            AND No_Lot = '" . $request['No_Lot_Product'][$item] . "' ");

            return redirect('/Claim/ShowClaim');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
