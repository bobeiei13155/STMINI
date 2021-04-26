<?php

namespace App\Http\Controllers\ReceiptPre;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;


class ReceiptPreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ShowReceiptPre()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission13')) {


                $preorders = DB::select(DB::raw("SELECT preorders.Id_Preorder,preorders.Status_Preorder,Receive_date,Preorder_date,FName_Emp,IFNULL(FName_Member,'ลูกค้าทั่วไป') as FName_Member  FROM preorders 
                JOIN employees on employees.Id_Emp = preorders.Id_Emp
                LEFT JOIN members on members.Id_Member = preorders.Id_Member 
                -- WHERE preorders.Status_Preorder = 1 
                "));

                return view("ReceiptPre.ShowReceiptPreorderForm")->with('preorders', $preorders);
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
    public function receipt_preorder($Id_Preorder)
    {



        $preorders = DB::select(DB::raw(" SELECT IFNULL(Discount_Cmember,0) as Discount ,preorders.Id_Preorder,Receive_date,Preorder_date,FName_Emp,IFNULL(FName_Member,'ลูกค้าทั่วไป') as FName_Member  FROM preorders 
        JOIN employees on employees.Id_Emp = preorders.Id_Emp
        LEFT JOIN members on members.Id_Member = preorders.Id_Member
				LEFT JOIN categorymembers on members.Cmember_Id = categorymembers.Id_Cmember
        WHERE preorders.Id_Preorder  =  '" . $Id_Preorder . "'
        "));


        $preorder_lists = DB::select(DB::raw(" SELECT Insurance,products.Name_Product,preorder_lists.Id_Product,preorder_lists.Price,preorder_lists.Deposit,preorder_lists.Amount_Preorder,(preorder_lists.Price-preorder_lists.Deposit) as Amount,products.Img_Product,Name_Brand
        FROM preorder_lists 
        JOIN preorders on preorder_lists.Id_Preorder = preorders.Id_Preorder
        JOIN products on products.Id_Product = preorder_lists.Id_Product
        JOIN brands on brands.Id_Brand = products.Brand_Id
        WHERE preorders.Id_Preorder  =  '" . $Id_Preorder . "'
        "));

        $brands = DB::table('brands')->where('Status', '=', '0')->get();
        $categories = DB::table('categories')->get();
        $gens = DB::table('gens')->where('Status', '=', '0')->get();
        $payments = DB::table('payments')->where('Status', '=', '0')->get();

        $sum = 0;
        foreach ($preorder_lists as $row) {
            $sum += $row->Price;
        }
        $sum_deposit = 0;
        foreach ($preorder_lists as $row) {
            $sum_deposit += $row->Amount;
        }

        return view("ReceiptPre.ReceiptPreorderForm")->with('preorders', $preorders)
            ->with('sum', $sum)->with('sum_deposit', $sum_deposit)
            ->with('preorder_lists', $preorder_lists)
            ->with('categories', $categories)->with('brands', $brands)
            ->with('gens', $gens)->with('payments', $payments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeReceiptPreorder(Request $request)
    {
        $Id_Preorder = $request->Id_Preorder;


        $Id_Product = $request['Id_Product_Preorder'];

        $receipt_preorders = DB::select(DB::raw(" SELECT IFNULL(Discount_Cmember,0) as Discount ,preorders.Total_Price
        ,preorders.Id_Preorder,Receive_date,Preorder_date,FName_Emp,members.Id_Member
        ,employees.Id_Emp  FROM preorders 
        JOIN employees on employees.Id_Emp = preorders.Id_Emp
        LEFT JOIN members on members.Id_Member = preorders.Id_Member
				LEFT JOIN categorymembers on members.Cmember_Id = categorymembers.Id_Cmember
        WHERE preorders.Id_Preorder  =  '" . $Id_Preorder . "'
        "));

        foreach ($receipt_preorders as $row) {
            $insert_receipt = array(

                'Id_Receipt_Pre' => $Id_Preorder,
                'Total_Price' => $row->Total_Price,
                'Id_Emp' => $row->Id_Emp,
                'Id_Member' => $row->Id_Member,
                'Receipt_Pre_Date' => $row->Preorder_date,
                'Id_Payment' => $request->Payment_Sell

            );
            print_r($insert_receipt);
            echo '<br>';
            DB::statement("UPDATE `stminidb`.`preorders` SET `Status_Preorder` = '2' WHERE `Id_Preorder` = '".$Id_Preorder."'");
            DB::table('receipt_pres')->insert([$insert_receipt]);
        }

        $preorder_lists = DB::select(DB::raw(" SELECT Insurance,
        products.Name_Product,preorder_lists.Id_Product,preorder_lists.Price,preorder_lists.Deposit,
        preorder_lists.Amount_Preorder,(preorder_lists.Price-preorder_lists.Deposit) as Amount,products.Img_Product
        ,Name_Brand,No_Preorder
        FROM preorder_lists 
        JOIN preorders on preorder_lists.Id_Preorder = preorders.Id_Preorder
        JOIN products on products.Id_Product = preorder_lists.Id_Product
        JOIN brands on brands.Id_Brand = products.Brand_Id
        WHERE preorders.Id_Preorder  =  '" . $Id_Preorder . "'
        "));


        foreach ($preorder_lists as $item => $value) {

            $insert_receipt_lists = array(

                'Id_Receipt_Pre' => $Id_Preorder,
                'No_Receipt_Pre' => $value->No_Preorder,
                'Id_Preorder' => $Id_Preorder,
                'No_Preorder' => $value->No_Preorder,
                'Insurance_Date' =>  $request['Insurance'][$item],
                'Amount' => $value->Amount_Preorder,
                'Deposit' => $value->Amount,
                'Price' => $value->Price,
            );
            print_r($insert_receipt_lists);
            echo '<br>';
            DB::table('receipt_pre_lists')->insert([$insert_receipt_lists]);

        }
        return redirect('/ReceiptPre/ShowReceiptPre');
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
