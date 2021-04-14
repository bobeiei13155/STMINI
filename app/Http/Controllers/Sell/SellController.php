<?php

namespace App\Http\Controllers\Sell;

use App\Telmem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use phpDocumentor\Reflection\Types\Null_;

class SellController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ShowSell()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission12')) {




                return view("Sell.ShowSellForm");
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

    public function select_promotion_payment(Request $request)
    {
        $value = $request->sub_Id_Brand;

        $promotionpays = DB::select(DB::raw("SELECT
        `promotionpays`.`Id_Promotion`,
        `promotionpays`.`Name_Promotion`,
        `promotionpays`.`Sdate_Promotion`,
        `promotionpays`.`Edate_Promotion`,
        `promotionpays`.`Payment_Amount`,
         `promotion_payments`.`Amount_Premium_Pro` as `Premium_Pro`,
         `premium_pros`.`Amount_Premium_Pro` as `Lot_Premium`,
         `premium_pros`.`Id_Premium_Pro`,
         `premium_pros`.`Img_Premium_Pro`,
         `premium_pros`.`Name_Premium_Pro`,
        `brands`.`Id_Brand`,
        `brands`.`Name_Brand` 
    FROM
        `promotionpays`
        INNER JOIN `brands` ON `brands`.`Id_Brand` = `promotionpays`.`Brand_Id`
        INNER JOIN `promotion_payments` ON `promotionpays`.`Id_Promotion` = `promotion_payments`.`Id_Promotion`
        INNER JOIN `premium_pros` ON `premium_pros`.`Id_Premium_Pro` = `promotion_payments`.`Id_Premium_Pro`
                     WHERE   `promotionpays`.`Brand_Id` = '" . $value . "'
                       AND        `promotion_payments`.`Amount_Premium_Pro` < `premium_pros`.`Amount_Premium_Pro`	

    "));

        $output = '<table class="table table-hover text-center "  >';


        foreach ($promotionpays as  $row) {
            $output .= '<tr>';
            $output .= '<td scope="row" width="6%"><img src="http://127.0.0.1:8000/storage/PremiumPro_image/' . $row->Img_Premium_Pro . '" alt="" width="50px" height="60px"></td>';


            $output .= ' <td scope="row" width="9%" ><input type="text" class="form-control text-center noHover"  value="' . $row->Name_Premium_Pro . '"  style="" disabled></td>';

            $output .= '  <input type="hidden" class="form-control text-center noHover"  value="' . $row->Id_Premium_Pro . '" name="Id_Premium_Pro_Sell[]" >';


            $output .= ' <td scope="row" width="5%" ><input type="text" class="form-control text-center noHover Show_Amount_Premium"  value="' . $row->Premium_Pro . '" id="Show_Amount_Premium" style="" readonly>';
            $output .= ' <input type="hidden" class="form-control text-center noHover Premium_Pro"  value="' . $row->Premium_Pro . '"  style="" readonly> ';
            $output .= ' <input type="hidden" class="form-control text-center noHover Lot_Premium"  value="' . $row->Lot_Premium . '"  style="" readonly> ';
            $output .= ' <input type="hidden" class="form-control text-center noHover Id_Brand_Pay_Remove"  value="' . $value . '"  style="" readonly> ';
            $output .= ' </td>';
            $output .= ' <td scope="row" width="1%"  > <label type="button" class="form-control "    style="background-color: #6586FA;border-color: #6586FA; color:#FFF;font-size:14px; border-radius: 5px;" disabled><i class="fas fa-fire-alt" style="color:#FFF"></i></label>';
            $output .= '  </td>';
            // });
            $output .= '<td  style="display :none" ><input type="text" class="form-control text-center noHover Id_Promotion_Pay"  value="' . $row->Id_Promotion . '" name="Id_Promotion_Pay[]" ></td>  ';
        }

        $output .= '</tr>';
        $output .= '</table>';
        // dd($Id_Promotion_Product);

        echo $output;
        // dd($promotionpays);
    }



    public function select_Promotion_Product(Request $request)
    {
        $Id_Promotion_Product = $request->Id_Promotion_Product;

        $Id_Product_ = DB::table('promotion_prods')->select('Id_Product')->where('Id_Promotion', '=', $Id_Promotion_Product)->groupBy('Id_Product')->first();
        // dd($Id_Product_Promotion);
        // $Id_Product = $request->Id_Product;
        $Id_Premium_Promotions = DB::select(DB::raw("SELECT `premium_pros`.`Name_Premium_Pro`
        , `promotion_prods`.`Amount_Premium_Pro` as `Premium_Pro`
        , `premium_pros`.`Amount_Premium_Pro` as `Lot_Premium`
        , `premium_pros`.`Id_Premium_Pro`, `premium_pros`.`Img_Premium_Pro` 
        from `promotion_prods` 
        inner join `premium_pros` on `premium_pros`.`Id_Premium_Pro` = `promotion_prods`.`Id_Premium_Pro` 
        where `Id_Promotion` = '" . $Id_Promotion_Product . "'"));
        // $q = DB::table('products')
        //     ->join('categories', 'categories.Id_Category', '=', 'products.Category_Id')
        //     ->join('brands', 'brands.Id_Brand', '=', 'products.Brand_Id')
        //     ->select('products.Name_Product', 'categories.Name_Category', 'brands.Name_Brand', 'products.Price', 'products.Img_Product')
        //     ->where('products.Id_Product', '=',  $Id_Product)
        //     ->get();

        // dd($Id_Premium_Promotions);
        // dd($Id_Premium_Promotions);

        $Id_Product_Promotions = DB::table('lot_lists')
            ->RightJoin('products', 'products.Id_Product', '=', 'lot_lists.Id_Product')
            ->join('categories', 'categories.Id_Category', '=', 'products.Category_Id')
            ->join('brands', 'brands.Id_Brand', '=', 'products.Brand_Id')
            ->select('products.Id_Product', 'products.Amount_Preorder', 'products.Name_Product', 'categories.Name_Category', 'brands.Name_Brand', 'products.Price', 'products.Img_Product', DB::raw('sum(lot_lists.Amount_Lot) as Amount_Lot'))->where('products.Id_Product', '=',  $Id_Product_->Id_Product)
            ->groupBy('products.Id_Product', 'products.Amount_Preorder', 'products.Name_Product', 'categories.Name_Category', 'brands.Name_Brand', 'products.Price', 'products.Img_Product')->orderBy('Id_Product')
            ->get();



        foreach ($Id_Product_Promotions as  $row) {
            $Amount_Lot =  $row->Amount_Lot - $row->Amount_Preorder;
        }


        if ($Amount_Lot == 0) {
            echo "<script>";
            echo "swal('สินค้าหมด');";
            // echo $output = "1";
            echo "</script>";
            exit();
        } else {
            $output = '<table class="table table-hover text-center "  >';


            foreach ($Id_Premium_Promotions as  $row) {
                $output .= '<tr>';
                $output .= '<td scope="row" width="6%"><img src="http://127.0.0.1:8000/storage/PremiumPro_image/' . $row->Img_Premium_Pro . '" alt="" width="50px" height="60px"></td>';


                $output .= ' <td scope="row" width="9%" ><input type="text" class="form-control text-center noHover"  value="' . $row->Name_Premium_Pro . '"  style="" disabled></td>';

                $output .= '  <input type="hidden" class="form-control text-center noHover "  value="' . $row->Id_Premium_Pro . '" name="Id_Premium_Pro_Sell[]" >';
                // $output .= ' <td scope="row" width="5%"  > <label type="button" class="form-control "    style="background-color: #F0B71A;border-color: #F0B71A; color:#FFF;font-size:16px; border-radius: 5px;" disabled><i class="fas fa-star" style="color:#FFF"></i></label>';
                // $output .= '  </td>';

                $output .= ' <td scope="row" width="5%" ><input type="text" class="form-control text-center noHover Show_Amount_Premium"  value="' . $row->Premium_Pro . '" id="Show_Amount_Premium" style="" readonly>';
                $output .= ' <input type="hidden" class="form-control text-center noHover Premium_Pro"  value="' . $row->Premium_Pro . '"  style="" readonly> ';
                $output .= ' <input type="hidden" class="form-control text-center noHover Lot_Premium"  value="' . $row->Lot_Premium . '"  style="" readonly> ';
                $output .= ' </td>';
                $output .= ' <td scope="row" width="1%"  > <label type="button" class="form-control "    style="background-color: #F0B71A;border-color: #F0B71A; color:#FFF;font-size:14px; border-radius: 5px;" disabled><i class="fas fa-star" style="color:#FFF"></i></label>';
                // });
                $output .= '<td  style="display :none" ><input type="text" class="form-control text-center noHover Id_Product_Remove"  value="' . $Id_Product_->Id_Product . '" name="Id_Product_Remove[]" ></td>  ';
            }

            $output .= '</tr>';
            $output .= '</table>';
            // dd($Id_Promotion_Product);

            echo $output;
        }
    }

    public function Detail_Promotion_Products(Request $request)
    {
        $Id_Promotion = $request->Id_Promotion;


        $promotions_product_detail = DB::select(DB::raw("SELECT `products`.`Name_Product`,`products`.`Price`,`products`.`Img_Product`,`promotions`.`Name_Promotion`, `premium_pros`.`Name_Premium_Pro`, `premium_pros`.`Img_Premium_Pro`, `promotion_prods`.`Amount_Premium_Pro` as `Amount_Premium `, `premium_pros`.`Amount_Premium_Pro` as `Lot` 
        from `promotions`
         inner join `promotion_prods` on `promotion_prods`.`Id_Promotion` = `promotions`.`Id_Promotion` 
         inner join `premium_pros` on `premium_pros`.`Id_Premium_Pro` = `promotion_prods`.`Id_Premium_Pro` 
         inner join `products` on `promotion_prods`.`Id_Product` = `products`.`Id_Product`
          where `promotions`.`Id_Promotion` = '" . $Id_Promotion . "' and `promotion_prods`.`Amount_Premium_Pro` < premium_pros.Amount_Premium_Pro "));

        if ($promotions_product_detail == null) {
            echo "<script>";
            echo "swal('สินค้าของแถมไม่พอ');";
            // echo $output = "1";
            echo "</script>";
            exit();
        } else {

            $output = ' <div class="row ">';
            $output .= ' <div class="input-group col-sm-6 ">';
            $output .= ' <div class="input-group-prepend"> ';
            $output .= '  <span class="input-group-text a1" id="inputGroup-sizing-default">รหัสโปรโมชั่นของแถม :</span> </div>';
            $output .= '  <input type="text" class="form-control" name="Ip_Id_Promotion_Product" id="Ip_Id_Promotion_Product" value="' . $Id_Promotion . '" style="background-color: #E8ECEE; border-radius: 0px 10px 10px 0px; " readonly>';
            $output .= '  </div>';

            foreach ($promotions_product_detail as $row) {
                $output .= ' <div class="input-group col-sm-6 ">';
                $output .= ' <div class="input-group-prepend"> ';
                $output .= '  <span class="input-group-text a1" id="inputGroup-sizing-default">ชื่อโปรโมชั่นของแถม :</span> </div>';
                $output .= '  <input type="text" class="form-control" name="Ip_Id_Promotion_Product" id="Ip_Id_Promotion_Product" value="' . $row->Name_Promotion . '" style="background-color: #E8ECEE; border-radius: 0px 10px 10px 0px; " readonly>';
                $output .= '  </div>';
                $output .= '  </div>';
                $output .= '  <br>';
                $output .= '<table class="table table-hover text-center">';
                $output .= '<thead>';
                $output .= '<tr>';
                $output .= '<th>รูปสินค้า</th>';
                $output .= '<th>ชื่อสินค้า</th>';
                $output .= '<th>ราคา</th>';
                $output .= '</tr>';
                $output .= '</thead>';
                $output .= '<tbody>';
                $output .= '<tr>';
                $output .= '<td scope="row"><img src="http://127.0.0.1:8000/storage/Products_image/' . $row->Img_Product . '" alt="" width="100px" height="100px"></td>';
                $output .= '<td>' . $row->Name_Product .  '</td>';
                $Price_number = number_format($row->Price, 2);
                $output .= '<td> ' . $Price_number .  '</td>';
                $output .= '</tr>';
                $output .= '</tbody>';
                $output .= '</table>';
                $output .= '  <br>';
                break;
            }
            $output .= '<table class="table table-hover text-center">';
            $output .= '<thead>';
            $output .= '<tr>';
            $output .= '<th >รูปของแถม</th>';
            $output .= '<th>ชื่อของแถม</th>';
            $output .= '</tr>';
            $output .= '</thead>';
            $output .= '<tbody>';

            foreach ($promotions_product_detail as $row) {

                $output .= '<tr>';
                $output .= '<td width="130px"><img src="http://127.0.0.1:8000/storage/PremiumPro_image/' . $row->Img_Premium_Pro . '" alt="" width="80px" height="80px"></td>';
                $output .= '<td  width="200px">' . $row->Name_Premium_Pro .  '</td>';
            }
            $output .= '</tr>';
            $output .= '</tbody>';
            $output .= '</table>';
            $output .= '  <br>';
            $output .= ' <hr align= “center" size= “2" width= “80%" color= "#F0B71A"> ';


            echo $output;
        }
    }


    public function Detail_Promotion_Payments(Request $request)
    {
        $Id_Promotion = $request->Id_Promotion;

        // dd($Id_Promotion);

        $promotionpays = DB::select(DB::raw("SELECT
        `promotionpays`.`Id_Promotion`,
        `promotionpays`.`Name_Promotion`,
        `promotionpays`.`Sdate_Promotion`,
        `promotionpays`.`Edate_Promotion`,
        `promotionpays`.`Payment_Amount`,
         `premium_pros`.`Img_Premium_Pro`,
         `premium_pros`.`Name_Premium_Pro`,
        `brands`.`Id_Brand`,
        `brands`.`Name_Brand` 
    FROM
        `promotionpays`
        INNER JOIN `brands` ON `brands`.`Id_Brand` = `promotionpays`.`Brand_Id`
        INNER JOIN `promotion_payments` ON `promotionpays`.`Id_Promotion` = `promotion_payments`.`Id_Promotion`
        INNER JOIN `premium_pros` ON `premium_pros`.`Id_Premium_Pro` = `promotion_payments`.`Id_Premium_Pro`
                     WHERE   `promotionpays`.`Id_Promotion` = '" . $Id_Promotion . "'
                       AND        `promotion_payments`.`Amount_Premium_Pro` < `premium_pros`.`Amount_Premium_Pro`	
    GROUP BY
        `promotionpays`.`Id_Promotion`,
        `promotionpays`.`Name_Promotion`,
        `promotionpays`.`Sdate_Promotion`,
        `promotionpays`.`Edate_Promotion`,
        `promotionpays`.`Payment_Amount`,
        `premium_pros`.`Img_Premium_Pro`,
        `premium_pros`.`Name_Premium_Pro`,
        `brands`.`Id_Brand`,
        `brands`.`Name_Brand`
    "));
        // dd($promotionpays);

        // if ($promotions_payments_detail == null) {
        //     echo "<script>";
        //     echo "swal('สินค้าของแถมไม่พอ');";
        //     // echo $output = "1";
        //     echo "</script>";
        //     exit();
        // } else {
        $output = ' <div class="row ">';
        $output .= ' <div class="input-group col-sm-6 ">';
        $output .= ' <div class="input-group-prepend"> ';
        $output .= '  <span class="input-group-text a1" id="inputGroup-sizing-default">รหัสโปรโมชั่นยอดชำระ :</span> </div>';
        $output .= '  <input type="text" class="form-control" name="Ip_Id_Promotion_Payment" id="Ip_Id_Promotion_Payment" value="' . $Id_Promotion . '" style="background-color: #E8ECEE; border-radius: 0px 10px 10px 0px; " readonly>';
        $output .= '  </div>';

        foreach ($promotionpays as $row) {

            $output .= ' <div class="input-group col-sm-6 ">';
            $output .= ' <div class="input-group-prepend"> ';
            $output .= '  <span class="input-group-text a1" id="inputGroup-sizing-default">ชื่อโปรโมชั่นยอดชำระ :</span> </div>';
            $output .= '  <input type="text" class="form-control" name="Ip_Name_Promotion_Payment" id="Ip_Id_Promotion_Payment" value="' . $row->Name_Promotion . '" style="background-color: #E8ECEE; border-radius: 0px 10px 10px 0px; " readonly>';
            $output .= '  </div>';
            $output .= '  </div>';
            $output .= '  <br>';
            $output .= ' <div class="row ">';
            $output .= ' <div class="input-group col-sm-6 ">';
            $output .= ' <div class="input-group-prepend"> ';
            $output .= '  <span class="input-group-text a1" id="inputGroup-sizing-default">ยี่ห้อ :</span> </div>';
            $output .= '  <input type="text" class="form-control" name="Ip_Name_Promotion_Brand" id="Ip_Id_Promotion_Product" value="' . $row->Name_Brand . '" style="background-color: #E8ECEE; border-radius: 0px 10px 10px 0px; " readonly>';
            $output .= ' <input type="hidden" class="form-control text-center noHover Id_Brand_Promotion_1"  value="' . $row->Id_Brand . '" name="Id_Brand_Promotion_1[]">';
            $output .= '  </div>';
            $Payment_Amount = number_format($row->Payment_Amount, 2);
            $output .= ' <div class="input-group col-sm-6 ">';
            $output .= ' <div class="input-group-prepend"> ';
            $output .= '  <span class="input-group-text a1" id="inputGroup-sizing-default">ยอดชำระ :</span> </div>';
            $output .= '  <input type="text" class="form-control" name="Ip_Id_Promotion_Product" id="Ip_Id_Promotion_Product" value="' . $Payment_Amount . '" style="background-color: #E8ECEE; border-radius: 0px 10px 10px 0px; " readonly>';
            $output .= ' <input type="hidden" class="form-control text-center noHover Payment_Amount"  value="' . $row->Payment_Amount . '" name="Payment_Amount[]">';
            $output .= '  </div>';
            $output .= '  </div>';
            $output .= '  <br>';
            break;
        }

        $output .= '<table class="table table-hover text-center">';
        $output .= '<thead>';
        $output .= '<tr>';
        $output .= '<th >รูปของแถม</th>';
        $output .= '<th>ชื่อของแถม</th>';
        $output .= '</tr>';
        $output .= '</thead>';
        $output .= '<tbody>';

        foreach ($promotionpays as $row) {

            $output .= '<tr>';
            $output .= '<td width="130px"><img src="http://127.0.0.1:8000/storage/PremiumPro_image/' . $row->Img_Premium_Pro . '" alt="" width="80px" height="80px"></td>';
            $output .= '<td  width="200px">' . $row->Name_Premium_Pro .  '</td>';
        }
        $output .= '</tr>';
        $output .= '</tbody>';
        $output .= '</table>';
        $output .= '  <br>';
        $output .= ' <hr align= “center" size= “2" width= “80%" color= "#6586FA"> ';


        echo $output;
        // }
    }

    public function createSell()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission12')) {


                $members = DB::table('members')
                    ->join('categorymembers', 'members.Cmember_Id', '=', 'categorymembers.Id_Cmember')
                    // ->join('telmems','members.Id_Member','=','telmems.Id_Member')
                    ->select('Id_Member', 'FName_Member', 'LName_Member', 'Name_Cmember', 'Discount_Cmember',)
                    ->get();

                $telmems = Telmem::all();

                $products = DB::table('products')->get();
                $brands = DB::table('brands')->get();
                $categories = DB::table('categories')->get();
                $gens = DB::table('gens')->get();
                // dd($products);
                // ->whereBetween('',[,])
                $lot_products = DB::table('lot_lists')->RightJoin('products', 'products.Id_Product', '=', 'lot_lists.Id_Product')
                    ->select('products.Name_Product', 'products.Id_Product', 'products.Amount_Preorder', DB::raw('sum(lot_lists.Amount_Lot) as Amount_Lot'))
                    ->groupBy('products.Name_Product', 'products.Id_Product', 'products.Amount_Preorder')->orderBy('Id_Product')
                    ->get();
                $date = date('Y-m-d');



                $promotions = DB::select(DB::raw("SELECT
                `Name_Promotion`,
                `Name_Product`,
                `Sdate_Promotion`,
                `Edate_Promotion`,
                `promotion_prods`.`Id_Product`,
                `promotion_prods`.`Id_Promotion`
                FROM
                `promotions`
                INNER JOIN `promotion_prods` ON `promotion_prods`.`Id_Promotion` = `promotions`.`Id_Promotion`
                INNER JOIN `premium_pros` ON `premium_pros`.`Id_Premium_Pro` = `promotion_prods`.`Id_Premium_Pro`
                INNER JOIN `products` ON `promotion_prods`.`Id_Product` = `products`.`Id_Product` 
                 WHERE
                     `Sdate_Promotion` <= '" . $date . "'
                            AND 	`Edate_Promotion` >= '" . $date . "'  AND
                                                   `promotion_prods`.`Amount_Premium_Pro` < premium_pros.Amount_Premium_Pro
																									 GROUP BY       `Name_Promotion`,
                                                                                                     `Name_Product`,
                `Sdate_Promotion`,
                `Edate_Promotion`,
                `promotion_prods`.`Id_Product`,
                `promotion_prods`.`Id_Promotion`
            "));

                $promotionpays = DB::select(DB::raw("SELECT
                `promotionpays`.`Id_Promotion`,
                `promotionpays`.`Name_Promotion`,
                `promotionpays`.`Sdate_Promotion`,
                `promotionpays`.`Edate_Promotion`,
                `promotionpays`.`Payment_Amount`,
                `brands`.`Id_Brand`,
                `brands`.`Name_Brand` 
            FROM
                `promotionpays`
                INNER JOIN `brands` ON `brands`.`Id_Brand` = `promotionpays`.`Brand_Id`
                INNER JOIN `promotion_payments` ON `promotionpays`.`Id_Promotion` = `promotion_payments`.`Id_Promotion`
                INNER JOIN `premium_pros` ON `premium_pros`.`Id_Premium_Pro` = `promotion_payments`.`Id_Premium_Pro`
                             WHERE
                                 `Sdate_Promotion` <= '" . $date . "'
                                        AND 	`Edate_Promotion` >= '" . $date . "' AND
                                                               `promotion_payments`.`Amount_Premium_Pro` < premium_pros.Amount_Premium_Pro	
            GROUP BY
                `promotionpays`.`Id_Promotion`,
                `promotionpays`.`Name_Promotion`,
                `promotionpays`.`Sdate_Promotion`,
                `promotionpays`.`Edate_Promotion`,
                `promotionpays`.`Payment_Amount`,
                `brands`.`Id_Brand`,
                `brands`.`Name_Brand`
            "));


                // dd($promotionpays);
                return view('Sell.SellForm')
                    ->with('members', $members)
                    ->with('telmems', $telmems)
                    ->with('lot_products', $lot_products)
                    ->with('promotions', $promotions)
                    ->with('promotionpays', $promotionpays)
                    ->with('products', $products)
                    ->with('brands', $brands)
                    ->with('gens', $gens)
                    ->with('categories', $categories);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }

    public function select_member(Request $request)
    {
        $Id_Member = $request->Id_Member;

        $Q_Name = DB::table('members')->select('FName_Member')->where('Id_Member', '=', $Id_Member)->get();

        foreach ($Q_Name as $row) {
            $name_member =  $row->FName_Member;
        }
        echo $name_member;
    }

    public function Select_Discount(Request $request)
    {
        $Id_Member = $request->Id_Member;

        $Q_discount = DB::table('members')->select('categorymembers.Discount_Cmember')->join('categorymembers', 'categorymembers.Id_Cmember', '=', 'members.Cmember_Id')->where('Id_Member', '=', $Id_Member)->get();

        foreach ($Q_discount as $row) {
            $Discount_Cmember =  $row->Discount_Cmember;
        }
        echo $Discount_Cmember;
    }

    public function select_id_member(Request $request)
    {


        $Id_Member = $request->Id_Member;

        echo $Id_Member;
    }


    public function select_Id_Product(Request $request)
    {


        $Id_Product = $request->Id_Product;

        // $q = DB::table('products')
        //     ->join('categories', 'categories.Id_Category', '=', 'products.Category_Id')
        //     ->join('brands', 'brands.Id_Brand', '=', 'products.Brand_Id')
        //     ->select('products.Name_Product', 'categories.Name_Category', 'brands.Name_Brand', 'products.Price', 'products.Img_Product')
        //     ->where('products.Id_Product', '=',  $Id_Product)
        //     ->get();

        $q = DB::table('lot_lists')
            ->RightJoin('products', 'products.Id_Product', '=', 'lot_lists.Id_Product')
            ->join('categories', 'categories.Id_Category', '=', 'products.Category_Id')
            ->join('brands', 'brands.Id_Brand', '=', 'products.Brand_Id')
            ->select('products.Id_Product', 'products.Amount_Preorder', 'products.Name_Product', 'categories.Name_Category', 'brands.Name_Brand', 'brands.Id_Brand', 'products.Price', 'products.Img_Product', DB::raw('sum(lot_lists.Amount_Lot) as Amount_Lot'))->where('products.Id_Product', '=',  $Id_Product)
            ->groupBy('products.Id_Product', 'products.Amount_Preorder', 'products.Name_Product', 'categories.Name_Category', 'brands.Name_Brand', 'brands.Id_Brand', 'products.Price', 'products.Img_Product')->orderBy('Id_Product')
            ->get();

        // dd($q);
        foreach ($q as  $row) {
            $Amount_Lot =  $row->Amount_Lot - $row->Amount_Preorder;
        }
        $Price = number_format($row->Price, 2);


        $output = '<table class="table table-hover text-center " >';
        // <img src="asset(storage)/Products_image/'.$row->Img_Product.'", alt="" width="80px" height="80px">

        foreach ($q as $row) {
            $output .= '<tr>';
            $output .= '<td scope="row" width="6%"><img src="http://127.0.0.1:8000/storage/Products_image/' . $row->Img_Product . '" alt="" width="80px" height="90px"></td>';




            $output .= ' <td scope="row" width="9%" ><input type="text" class="form-control text-center noHover"  value="' . $row->Name_Product . '"  style="" disabled></td>';

            $output .= '  <input type="hidden" class="form-control text-center noHover Id_Product_Sell"  value="' . $row->Id_Product . '" name="Id_Product_Sell[]" >';


            $output .= ' <td scope="row" width="5%" ><input type="text" class="form-control text-center noHover"  value="' . $row->Name_Brand . '" name="Amount_Remain[]" readonly>';
            $output .= ' <input type="hidden" class="form-control text-center noHover Id_Brand"  value="' . $row->Id_Brand . '" name="Id_Brand[]">';
            $output .= ' </td>';
            $output .= ' <td scope="row" width="5%" >';

            $output .= '  <input type="text" class="form-control text-center noHover "  value="' . $Price . '" " readonly> ';
            $output .= ' <input type="hidden" class="form-control text-center noHover the_input_cost"  value="' . $row->Price . '" name="Price_Sell[]">';
            $output .= '  </td>';
            $output .= ' <td scope="row" width="5%" ><input type="number" class="form-control text-center noHover the_input_approve" name="Amount_Sell[]" value="1" min="1" max="' . ($row->Amount_Lot - $row->Amount_Preorder) . '" title= "กรุณาใส่ให้ตรง" required></td>';
            $output .= ' <td scope="row" width="5%" ><input type="text" class="form-control text-center noHover total_cost_s"  value="' . $Price . '" " readonly>
                            <input type="hidden" class="form-control text-center noHover  total_cost"  value="' . $row->Price . '" name="total_cost[]" >         ';
            $output .= ' </td> ';
            $output .= ' <td scope="row" width="5%" > <button type="button" class="btn btn-danger remove " id="" value="' . $row->Id_Product . '"  style="border-radius: 5px; width: 60px; "> <i class="fas fa-trash" style="margin-right: 5px;"></i>  </button></td>';
            // });

            $output .= ' </tr>';
        }

        echo $output;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
