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

                // $sells = DB::select(DB::raw("SELECT sells.Id_Sell , FName_Emp , IFNULL(FName_Member,'ลูกค้าทั่วไป') as Name_Member,Sell_Date,Payment FROM sells 
                // JOIN payments on payments.Id_Payment = sells.Id_Payment 
                // JOIN employees on employees.Id_Emp = sells.Id_Emp 
                // LEFT JOIN members on members.Id_Member = sells.Id_Member 
                // WHERE sells.Status = '0' "));

                return view("Claim.ShowClaimForm");
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
    public function createClaim()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission12')) {


                $sells = DB::table('sells')->select('sells.Id_Sell', 'FName_Emp', 'FName_Member')->join('employees', 'employees.Id_Emp', '=', 'sells.Id_Emp')
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
                // dd($payments);
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
        $Id_Sell =  $request->Id_Sell;;
        $date = date('Y-m-d');
        $sells = DB::select(DB::raw("SELECT Name_Product,Amount_Sell,End_Insurance,sell_lists.Id_Product  FROM sell_lists
        JOIN lot_lists  on lot_lists.Id_Lot = sell_lists.Id_Lot  and lot_lists.No_Lot = sell_lists.No_Lot
        JOIN products  on products.Id_Product = sell_lists.Id_Product WHERE sell_lists.Id_Sell = '" . $Id_Sell . "' AND '" . $date . "' <= End_Insurance
        "));


        $output = "";

        foreach ($sells as $row) {
            $output .= '<tr>';
            $output .= '<td width="9%"><input type="text" class="form-control text-center noHover"  value="' . $row->Name_Product .  '" readonly>
            <input type="hidden" class="form-control text-center noHover"  value="' . $Id_Sell .  '" name="Id_Sell_Product[]" > 
            <input type="hidden" class="form-control text-center noHover"  value="' . $row->Id_Product .  '" name="Id_Product_Sell[]" > </td>';
            $output .= '   ';
            $output .= ' <td width="2%">   <input type="text" class="form-control text-center noHover"  value="' . $row->Amount_Sell .  ' "readonly></td>';
            // $output .= ' <td>  <input type="hidden" class="form-control text-center noHover"  value="' . $row->Id_Product .  '" name="Id_Product[]" ></td>';
            $output .= '<td width="6%"><input type="text" class="form-control text-center" value="' . $row->End_Insurance .  '" " name="End_Insurance[]"readonly></td>';
            $output .= '<td width="2%"><button type="button" class="btn btn-info select_Id_Product " name="select_Id_Product"  class="input-group-text " style="border-radius: 5px;  "> <i class="fas fa-tools"></i></button></td>';
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
