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

                $sells = DB::select(DB::raw("SELECT sells.Id_Sell , FName_Emp , IFNULL(FName_Member,'ลูกค้าทั่วไป') as Name_Member,Sell_Date,Payment FROM sells 
                JOIN payments on payments.Id_Payment = sells.Id_Payment 
                JOIN employees on employees.Id_Emp = sells.Id_Emp 
                LEFT JOIN members on members.Id_Member = sells.Id_Member 
                WHERE sells.Status = '0' "));

                return view("Sell.ShowSellForm")->with('sells', $sells);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }



    public function Bill($Id_Sell)
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission12')) {

                $sells = DB::select(DB::raw("SELECT sells.Id_Sell , FName_Emp , IFNULL(FName_Member,'ลูกค้าทั่วไป') as Name_Member,Sell_Date,Payment FROM sells 
                JOIN payments on payments.Id_Payment = sells.Id_Payment 
                JOIN employees on employees.Id_Emp = sells.Id_Emp 
                LEFT JOIN members on members.Id_Member = sells.Id_Member  WHERE sells.Id_Sell ='" . $Id_Sell . "'"));
                // dd($sells);

                $product_sells = DB::select(DB::raw("SELECT sell_lists.Id_Sell ,
                sell_lists.No_Sell ,
                sell_lists.Id_Lot,
                sell_lists.No_Lot,
                lot_lists.Id_Product,
                sell_lists.Amount_Sell,
                products.Name_Product,
                sell_lists.End_Insurance,
                sell_lists.Total_Price
                
                FROM sell_lists 
                JOIN sells on sell_lists.Id_Sell = sells.Id_Sell 
                JOIN payments on payments.Id_Payment = sells.Id_Payment 
                JOIN employees on employees.Id_Emp = sells.Id_Emp 
                LEFT JOIN members on members.Id_Member = sells.Id_Member
                JOIN lot_lists on sell_lists.Id_Lot = lot_lists.Id_Lot and sell_lists.No_Lot = lot_lists.No_Lot 
                JOIN products on lot_lists.Id_Product = products.Id_Product 
                WHERE sells.Id_Sell ='" . $Id_Sell . "'
                "));


                $premium_payments = DB::select(DB::raw("SELECT Name_Premium_Pro,promotion_payments.Amount_Premium_Pro
                FROM sell_lists 
                JOIN sells on sell_lists.Id_Sell = sells.Id_Sell 
                JOIN payments on payments.Id_Payment = sells.Id_Payment 
                JOIN employees on employees.Id_Emp = sells.Id_Emp 
                LEFT JOIN members on members.Id_Member = sells.Id_Member
                JOIN lot_lists on sell_lists.Id_Lot = lot_lists.Id_Lot and sell_lists.No_Lot = lot_lists.No_Lot 
                JOIN products on lot_lists.Id_Product = products.Id_Product 
                JOIN sell_promo_payments on sell_lists.Id_Sell = sell_promo_payments.Id_Sell and sell_lists.No_Sell = sell_promo_payments.No_Sell
                JOIN promotionpays on sell_promo_payments.Id_Promotion_Payment = promotionpays.Id_Promotion 
                JOIN promotion_payments on promotion_payments.Id_Promotion = promotionpays.Id_Promotion 
                LEFT JOIN premium_pros on premium_pros.Id_Premium_Pro = promotion_payments.Id_Premium_Pro 
                where sell_lists.Id_Sell ='" . $Id_Sell . "'
                "));

                // dd( $premium_payments); 
                $premium_products = DB::select(DB::raw("SELECT Name_Premium_Pro,promotion_prods.Amount_Premium_Pro,Amount_Sell*promotion_prods.Amount_Premium_Pro as Amount_Premium_Pro
                FROM sell_lists 
                JOIN sells on sell_lists.Id_Sell = sells.Id_Sell 
                JOIN payments on payments.Id_Payment = sells.Id_Payment 
                JOIN employees on employees.Id_Emp = sells.Id_Emp 
                LEFT JOIN members on members.Id_Member = sells.Id_Member
                JOIN lot_lists on sell_lists.Id_Lot = lot_lists.Id_Lot and sell_lists.No_Lot = lot_lists.No_Lot 
                JOIN products on lot_lists.Id_Product = products.Id_Product 
                 JOIN sell_promo_products on sell_lists.Id_Sell = sell_promo_products.Id_Sell and sell_lists.No_Sell = sell_promo_products.No_Sell
                JOIN promotions on sell_promo_products.Id_Promotion_Product = promotions.Id_Promotion 
                LEFT JOIN promotion_prods on promotion_prods.Id_Promotion = promotions.Id_Promotion 
                LEFT JOIN premium_pros on premium_pros.Id_Premium_Pro = promotion_prods.Id_Premium_Pro 
                where sell_lists.Id_Sell ='" . $Id_Sell . "'
                "));



                $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
                $fontDirs = $defaultConfig['fontDir'];
                $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
                $fontData = $defaultFontConfig['fontdata'];
                $html = view('Sell.Show_ReceiptForm')->with('sells', $sells)->with('product_sells', $product_sells)
                    ->with('premium_payments', $premium_payments)->with('premium_products', $premium_products)
                    ->render();
                $mpdf = new \Mpdf\Mpdf([
                    'fontDir' => array_merge($fontDirs, [
                        storage_path('fonts/'),
                    ]),
                    'fontdata' => $fontData + [
                        'sarabun_new' => [
                            'R' => 'THSarabunNew.ttf',
                            'I' => 'THSarabunNew Italic.ttf',
                            'B' => 'THSarabunNew Bold.ttf',
                        ],
                    ],
                    'default_font' => 'sarabun_new',
                    'format' => [130, 230],
                ]);
                $mpdf->WriteHTML($html);
                $mpdf->Output();
                return $mpdf->Output();
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

    public function Detail_Sell(Request $request)
    {
        $Id_Sell = $request->Id_Sell;

        $sells = DB::select(DB::raw("SELECT sells.Id_Sell , FName_Emp , IFNULL(FName_Member,'ลูกค้าทั่วไป') as Name_Member,Sell_Date,Payment FROM sells 
        JOIN payments on payments.Id_Payment = sells.Id_Payment 
        JOIN employees on employees.Id_Emp = sells.Id_Emp 
        LEFT JOIN members on members.Id_Member = sells.Id_Member  WHERE sells.Id_Sell ='" . $Id_Sell . "'"));
        // dd($sells);

        $product_sells = DB::select(DB::raw("SELECT sell_lists.Id_Sell ,
        sell_lists.No_Sell ,
        sell_lists.Id_Lot,
        sell_lists.No_Lot,
        lot_lists.Id_Product,
        sell_lists.Amount_Sell,
        products.Name_Product,
        sell_lists.Total_Price
        
        FROM sell_lists 
        JOIN sells on sell_lists.Id_Sell = sells.Id_Sell 
        JOIN payments on payments.Id_Payment = sells.Id_Payment 
        JOIN employees on employees.Id_Emp = sells.Id_Emp 
        LEFT JOIN members on members.Id_Member = sells.Id_Member
        JOIN lot_lists on sell_lists.Id_Lot = lot_lists.Id_Lot and sell_lists.No_Lot = lot_lists.No_Lot 
        JOIN products on lot_lists.Id_Product = products.Id_Product 
        WHERE sells.Id_Sell ='" . $Id_Sell . "'
        "));

        $premium_payments = DB::select(DB::raw("SELECT Name_Premium_Pro,promotion_payments.Amount_Premium_Pro
        FROM sell_lists 
        JOIN sells on sell_lists.Id_Sell = sells.Id_Sell 
        JOIN payments on payments.Id_Payment = sells.Id_Payment 
        JOIN employees on employees.Id_Emp = sells.Id_Emp 
        LEFT JOIN members on members.Id_Member = sells.Id_Member
        JOIN lot_lists on sell_lists.Id_Lot = lot_lists.Id_Lot and sell_lists.No_Lot = lot_lists.No_Lot 
        JOIN products on lot_lists.Id_Product = products.Id_Product 
         JOIN sell_promo_payments on sell_lists.Id_Sell = sell_promo_payments.Id_Sell and sell_lists.No_Sell = sell_promo_payments.No_Sell
         JOIN promotionpays on sell_promo_payments.Id_Promotion_Payment = promotionpays.Id_Promotion 
         JOIN promotion_payments on promotion_payments.Id_Promotion = promotionpays.Id_Promotion 
        LEFT JOIN premium_pros on premium_pros.Id_Premium_Pro = promotion_payments.Id_Premium_Pro 
        where sell_lists.Id_Sell ='" . $Id_Sell . "'
        "));


        $premium_products = DB::select(DB::raw("SELECT Name_Premium_Pro,promotion_prods.Amount_Premium_Pro,Amount_Sell*promotion_prods.Amount_Premium_Pro as Amount_Premium_Pro
        FROM sell_lists 
        JOIN sells on sell_lists.Id_Sell = sells.Id_Sell 
        JOIN payments on payments.Id_Payment = sells.Id_Payment 
        JOIN employees on employees.Id_Emp = sells.Id_Emp 
        LEFT JOIN members on members.Id_Member = sells.Id_Member
        JOIN lot_lists on sell_lists.Id_Lot = lot_lists.Id_Lot and sell_lists.No_Lot = lot_lists.No_Lot 
        JOIN products on lot_lists.Id_Product = products.Id_Product 
         JOIN sell_promo_products on sell_lists.Id_Sell = sell_promo_products.Id_Sell and sell_lists.No_Sell = sell_promo_products.No_Sell
         JOIN promotions on sell_promo_products.Id_Promotion_Product = promotions.Id_Promotion 
        LEFT JOIN promotion_prods on promotion_prods.Id_Promotion = promotions.Id_Promotion 
        LEFT JOIN premium_pros on premium_pros.Id_Premium_Pro = promotion_prods.Id_Premium_Pro 
        where sell_lists.Id_Sell ='" . $Id_Sell . "'
        "));
        // dd($premium_payment);

        $output = '';



        foreach ($sells as  $row) {

            $output .= ' <div class="row ">';
            $output .= ' <div class="input-group col-sm-6 ">';
            $output .= ' <div class="input-group-prepend"> ';
            $output .= '  <span class="input-group-text a1" id="inputGroup-sizing-default" style="width:120px">พนักงานขาย :</span> </div>';
            $output .= '  <input type="text" class="form-control" name="Ip_Id_Promotion_Product" id="Ip_Id_Promotion_Product" value="' . $row->FName_Emp . '" style="background-color: #E8ECEE; border-radius: 0px 10px 10px 0px; " readonly>';
            $output .= '  </div>';
            $output .= ' <div class="input-group col-sm-6 ">';
            $output .= ' <div class="input-group-prepend"> ';
            $output .= '  <span class="input-group-text a1" id="inputGroup-sizing-default" style="width:120px">ลูกค้า :</span> </div>';
            $output .= '  <input type="text" class="form-control" name="Ip_Id_Promotion_Product" id="Ip_Id_Promotion_Product" value="' . $row->Name_Member . '" style="background-color: #E8ECEE; border-radius: 0px 10px 10px 0px; " readonly>';
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
        $output .= ' <th>ราคา</th>';
        $output .= '  </tr> ';
        $output .= ' </thead> ';
        $output .= '  <tbody>';



        foreach ($product_sells as  $product_sell) {
            $output .= '<tr>';
            $output .= '<td>' . $product_sell->Name_Product . '</td>';
            $output .= '<td>' . $product_sell->Amount_Sell . '</td>';
            $output .= '<td>' . number_format($product_sell->Total_Price, 2) . '</td>';
            $output .= '</tr>';
        }
        $output .= '  </tbody>';
        $output .= ' </table> ';


        $output .= ' <h2>รายการของแถมโปรโมชั่นยอดชำระ</h2>';
        $output .= ' <table class="table table-striped table-hover  text-center ">';
        $output .= ' <thead>';
        $output .= ' <tr>';
        $output .= ' <th>ชื่อของแถม</th>';
        $output .= ' <th>จำนวนสินค้าของแถม</th>';
        $output .= '  </tr> ';
        $output .= ' </thead> ';
        $output .= '  <tbody>';

        foreach ($premium_payments as  $premium_payment) {
            $output .= '<tr>';
            $output .= '<td>' . $premium_payment->Name_Premium_Pro . '</td>';
            $output .= '<td>' . $premium_payment->Amount_Premium_Pro . '</td>';
            $output .= '</tr>';
        }
        $output .= '  </tbody>';
        $output .= ' </table> ';


        $output .= ' <h2>รายการของแถมโปรโมชั่นของแถม</h2>';
        $output .= ' <table class="table table-striped table-hover  text-center ">';
        $output .= ' <thead>';
        $output .= ' <tr>';
        $output .= ' <th>ชื่อของแถม</th>';
        $output .= ' <th>จำนวนสินค้าของแถม</th>';
        $output .= '  </tr> ';
        $output .= ' </thead> ';
        $output .= '  <tbody>';

        foreach ($premium_products as  $premium_product) {
            $output .= '<tr>';
            $output .= '<td>' . $premium_product->Name_Premium_Pro . '</td>';
            $output .= '<td>' . $premium_product->Amount_Premium_Pro . '</td>';
            $output .= '</tr>';
        }
        $output .= '  </tbody>';
        $output .= ' </table> ';



        echo $output;
    }





    public function delete_sell(Request $request)
    {
        $Id_Sell = $request->Id_Sell;

        $sells = DB::select(DB::raw("SELECT sells.Id_Sell , FName_Emp , IFNULL(FName_Member,'ลูกค้าทั่วไป') as Name_Member,Sell_Date,Payment FROM sells 
        JOIN payments on payments.Id_Payment = sells.Id_Payment 
        JOIN employees on employees.Id_Emp = sells.Id_Emp 
        LEFT JOIN members on members.Id_Member = sells.Id_Member  WHERE sells.Id_Sell ='" . $Id_Sell . "'"));


        $product_sells = DB::select(DB::raw("SELECT sell_lists.Id_Sell ,
        sell_lists.No_Sell ,
        sell_lists.Id_Lot,
        sell_lists.No_Lot,
        lot_lists.Id_Product,
        sell_lists.Amount_Sell,
        products.Name_Product,
        sell_lists.Total_Price
        
        FROM sell_lists 
        JOIN sells on sell_lists.Id_Sell = sells.Id_Sell 
        JOIN payments on payments.Id_Payment = sells.Id_Payment 
        JOIN employees on employees.Id_Emp = sells.Id_Emp 
        LEFT JOIN members on members.Id_Member = sells.Id_Member
        JOIN lot_lists on sell_lists.Id_Lot = lot_lists.Id_Lot and sell_lists.No_Lot = lot_lists.No_Lot 
        JOIN products on lot_lists.Id_Product = products.Id_Product 
        WHERE sells.Id_Sell ='" . $Id_Sell . "'
        "));

        // dd($product_sells);

        $premium_payments = DB::select(DB::raw("SELECT Name_Premium_Pro,promotion_payments.Amount_Premium_Pro,premium_pros.Id_Premium_Pro
        FROM sell_lists 
        JOIN sells on sell_lists.Id_Sell = sells.Id_Sell 
        JOIN payments on payments.Id_Payment = sells.Id_Payment 
        JOIN employees on employees.Id_Emp = sells.Id_Emp 
        LEFT JOIN members on members.Id_Member = sells.Id_Member
        JOIN lot_lists on sell_lists.Id_Lot = lot_lists.Id_Lot and sell_lists.No_Lot = lot_lists.No_Lot 
        JOIN products on lot_lists.Id_Product = products.Id_Product 
         JOIN sell_promo_payments on sell_lists.Id_Sell = sell_promo_payments.Id_Sell and sell_lists.No_Sell = sell_promo_payments.No_Sell
         JOIN promotionpays on sell_promo_payments.Id_Promotion_Payment = promotionpays.Id_Promotion 
         JOIN promotion_payments on promotion_payments.Id_Promotion = promotionpays.Id_Promotion 
        LEFT JOIN premium_pros on premium_pros.Id_Premium_Pro = promotion_payments.Id_Premium_Pro 
        where sell_lists.Id_Sell ='" . $Id_Sell . "'
        "));


        $premium_products = DB::select(DB::raw("SELECT Name_Premium_Pro,promotion_prods.Amount_Premium_Pro,Amount_Sell*promotion_prods.Amount_Premium_Pro as Amount_Premium_Pro,premium_pros.Id_Premium_Pro
        FROM sell_lists 
        JOIN sells on sell_lists.Id_Sell = sells.Id_Sell 
        JOIN payments on payments.Id_Payment = sells.Id_Payment 
        JOIN employees on employees.Id_Emp = sells.Id_Emp 
        LEFT JOIN members on members.Id_Member = sells.Id_Member
        JOIN lot_lists on sell_lists.Id_Lot = lot_lists.Id_Lot and sell_lists.No_Lot = lot_lists.No_Lot 
        JOIN products on lot_lists.Id_Product = products.Id_Product 
         JOIN sell_promo_products on sell_lists.Id_Sell = sell_promo_products.Id_Sell and sell_lists.No_Sell = sell_promo_products.No_Sell
         JOIN promotions on sell_promo_products.Id_Promotion_Product = promotions.Id_Promotion 
        LEFT JOIN promotion_prods on promotion_prods.Id_Promotion = promotions.Id_Promotion 
        LEFT JOIN premium_pros on premium_pros.Id_Premium_Pro = promotion_prods.Id_Premium_Pro 
        where sell_lists.Id_Sell ='" . $Id_Sell . "'
        "));
        // dd($premium_products);
        foreach ($product_sells as $product_sell) {


            DB::statement("UPDATE lot_lists SET Amount_Lot = Amount_Lot + '" . $product_sell->Amount_Sell . "' 
               WHERE Id_Lot = '" . $product_sell->Id_Lot . "' AND No_Lot = '" . $product_sell->No_Lot . "'");
        }
        foreach ($premium_payments as $premium_payment) {
            DB::statement("UPDATE premium_pros SET Amount_Premium_Pro = Amount_Premium_Pro + '" . $premium_payment->Amount_Premium_Pro . "' 
               WHERE Id_Premium_Pro = '" . $premium_payment->Id_Premium_Pro . "' ");
        }
        foreach ($premium_products as $premium_product) {
            DB::statement("UPDATE premium_pros SET Amount_Premium_Pro = Amount_Premium_Pro + '" . $premium_product->Amount_Premium_Pro . "' 
            WHERE Id_Premium_Pro = '" . $premium_product->Id_Premium_Pro . "' ");
        }
        DB::statement("UPDATE sells SET sells.Status = 1 
        WHERE sells.Id_Sell = '" . $Id_Sell . "' ");

        return redirect('/Sell/ShowSell');
    }







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

        $output = '';


        foreach ($promotionpays as  $row) {
            $output .= '<tr>';
            $output .= '<td scope="row" width="6%"><img src="http://127.0.0.1:8000/storage/PremiumPro_image/' . $row->Img_Premium_Pro . '" alt="" width="50px" height="60px"></td>';


            $output .= ' <td scope="row" width="9%" ><input type="text" class="form-control text-center noHover"  value="' . $row->Name_Premium_Pro . '"  style="" disabled></td>';

            $output .= '  <input type="hidden" class="form-control text-center noHover"  value="' . $row->Id_Premium_Pro . '" name="Id_Premium_Pro_Sell[]" >';



            $output .= ' <td scope="row" width="5%" ><input type="text" class="form-control text-center noHover Show_Amount_Premium"  value="' . $row->Premium_Pro . '" id="Show_Amount_Premium" style="" readonly>';
            $output .= ' <input type="hidden" class="form-control text-center noHover Premium_Pro"  value="' . $row->Premium_Pro . '"  style=""   readonly> ';
            $output .= ' <input type="hidden" class="form-control text-center noHover  premium_sell"  value="' . $row->Premium_Pro . '"  style="" name="premium_sell[]" readonly> ';
            $output .= ' <input type="hidden" class="form-control text-center noHover Lot_Premium"  value="' . $row->Lot_Premium . '"  style="" readonly> ';
            $output .= ' <input type="hidden" class="form-control text-center noHover Id_Brand_Pay_Remove"  value="' . $value . '"  style="" readonly> ';
            $output .= ' <input type="hidden" class="form-control text-center noHover Id_Promotion_Pay_Insert"  value="' . $row->Id_Promotion . '" name="Id_Promotion_Pay_Insert[]" >';
            $output .= ' </td>';
            $output .= ' <td scope="row" width="1%"  > <label type="button" class="form-control "    style="background-color: #6586FA;border-color: #6586FA; color:#FFF;font-size:14px; border-radius: 5px;" disabled><i class="fas fa-fire-alt" style="color:#FFF"></i></label>';
            $output .= '  </td>';
            // });
            $output .= '<td  style="display :none" ><input type="text" class="form-control text-center noHover Id_Promotion_Pay"  value="' . $row->Id_Promotion . '" name="Id_Promotion_Pay[]" ></td>  ';
            $output .= '<td  style="display :none" ></td>';
            $output .= '</tr>';
            $Id_Promotion_Pay = $row->Id_Promotion;
        }
        $output .= '<tr >';
        $output .= ' <td style="display :none"><input type="text" class="form-control text-center noHover for_id_promotion_pay ' . $value . '"  value="' . $Id_Promotion_Pay . '" name="for_id_promotion_pay[]" style="" readonly>
        <input type="text" class="form-control text-center noHover for_id_promotion_pay ' . $value . '"  value="' . $value . '" name="brand_id_promotion_pay[]" style="" readonly></td>';
        $output .= '</tr>';

        // dd($Id_Promotion_Product);

        echo $output;
        // dd($promotionpays);
    }



    public function select_Promotion_Product(Request $request)
    {

        $Id_Promotion_Product = $request->Id_Promotion_Product;

        if (is_null($Id_Promotion_Product)) {
            $Id_Lot = $request->Id_Lot;
            $rowid = $request->rowid;
            // dd($rowid );



            $output = '';
            $output .= '<tr class="rows' . $rowid . '"   hidden>';
            $output .= '<td scope="row" width="6%" ></td>';

            $output .= ' <td scope="row" width="9%" ></td>';

            $output .= ' <td scope="row" width="5%"  >';
            $output .= ' <input type="hidden" class="form-control text-center noHover for_id_promotion_product"  name = "for_id_promotion_product[]" value="0"  style="" readonly> ';
            $output .= ' <input type="hidden" class="form-control text-center noHover rows"  name = "rows[]" value="' . $rowid . '"  style="" readonly> ';
            $output .= ' </td>';
            $output .= ' <td scope="row" width="1%"  >     </td>';
            // });
            $output .= '<td  style="display :none" ></td>  ';
            $output .= '<td  style="display :none" ></td>  ';
            $output .= '<td  style="display :none" ></td>  ';
            $output .= '</tr>';


            echo $output;


            // dd($Id_Promotion_Product);
        } else {
            $Id_Lot = $request->Id_Lot;
            $rowid = $request->rowid;
            // dd($Id_Lot);
            $Id_Product_ = DB::table('promotions')->select('Id_Product')->where('Id_Promotion', '=', $Id_Promotion_Product)->groupBy('Id_Product')->first();


            // $q = DB::table('lot_lists')
            //     ->RightJoin('products', 'products.Id_Product', '=', 'lot_lists.Id_Product')
            //     ->join('categories', 'categories.Id_Category', '=', 'products.Category_Id')
            //     ->join('brands', 'brands.Id_Brand', '=', 'products.Brand_Id')
            //     ->select('products.Id_Product', 'products.Amount_Preorder', 'products.Insurance', 'products.Name_Product', 'categories.Name_Category', 'brands.Name_Brand', 'brands.Id_Brand', 'products.Price', 'products.Img_Product', 'lot_lists.Amount_Lot')->where('products.Id_Product', '=',  $Id_Product_)->where('lot_lists.Id_Lot', '=',  $Id_Lot)
            //     ->get();

            // dd($q);

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
                ->select('products.Id_Product', 'products.Amount_Preorder', 'products.Name_Product', 'categories.Name_Category', 'brands.Name_Brand', 'products.Price', 'products.Img_Product', 'lot_lists.Amount_Lot')->where('products.Id_Product', '=',  $Id_Product_->Id_Product)
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
                $output = '';

                $No_Premium = 0;
                foreach ($Id_Premium_Promotions as  $row) {
                    $output .= '<tr class="rows' . $rowid . '">';
                    $No_Premium++;

                    $output .= '<td scope="row" width="6%"><img src="http://127.0.0.1:8000/storage/PremiumPro_image/' . $row->Img_Premium_Pro . '" alt="" width="50px" height="60px"></td>';


                    $output .= ' <td scope="row" width="9%" ><input type="text" class="form-control text-center noHover"  value="' . $row->Name_Premium_Pro . '"  style="" disabled></td>';

                    $output .= '  <input type="hidden" class="form-control text-center noHover Id_Premium_Pro_Sell"  value="' . $row->Id_Premium_Pro . '" name="Id_Premium_Pro_Sell[]" >';
                    // $output .= ' <td scope="row" width="5%"  > <label type="button" class="form-control "    style="background-color: #F0B71A;border-color: #F0B71A; color:#FFF;font-size:16px; border-radius: 5px;" disabled><i class="fas fa-star" style="color:#FFF"></i></label>';
                    // $output .= '  </td>';

                    $output .= ' <td scope="row" width="5%" ><input type="text" class="form-control text-center noHover ' . $rowid . ' No' . $No_Premium . '"  value="' . $row->Premium_Pro . '" id="' . $rowid . '" style="" readonly>';
                    $output .= ' <input type="hidden" class="form-control text-center noHover ' . $rowid . ' premium_sell No' . $No_Premium . '"  value="' . $row->Premium_Pro . '"  style="" name="premium_sell[]" readonly> ';
                    $output .= ' <input type="hidden" class="form-control text-center noHover ' . $rowid . ' Premium_Pro' . $No_Premium . '"  value="' . $row->Premium_Pro . '"  style="" readonly> ';
                    $output .= ' <input type="hidden" class="form-control text-center noHover Lot_Premium"  value="' . $row->Lot_Premium . '"  style="" readonly> ';
                    $output .= ' <input type="hidden" class="form-control text-center noHover Id_Promotion_Product"  value="' . $Id_Promotion_Product . '"  style="" name="Id_Promotion_Product[]" readonly> ';
                    $output .= ' </td>';
                    $output .= ' <td scope="row" width="1%"  > <label type="button" class="form-control "    style="background-color: #F0B71A;border-color: #F0B71A; color:#FFF;font-size:14px; border-radius: 5px;" disabled><i class="fas fa-star" style="color:#FFF"></i></label>';
                    // });
                    $output .= '<td  style="display :none" ><input type="text" class="form-control text-center noHover Id_Product_Remove"  value="' . $Id_Product_->Id_Product . '" name="Id_Product_Remove[]" ></td>  ';
                    $output .= '<td  style="display :none" ><input type="text" class="form-control text-center noHover Id_Lot_Remove "  value="' . $Id_Lot . '" name="Id_Lot_Remove[]" ></td>  ';
                    $output .= '<td  style="display :none" ><input type="text" class="form-control text-center noHover Id_Promotion_Product "  value="' . $Id_Promotion_Product . '" name="Id_Promotion_Product[]" ></td>  ';

                    $output .= '</tr>';
                }
                $output .= '<tr class="rows' . $rowid . '">';
                $output .= ' <td style="display :none"><input type="text" class="form-control text-center noHover for_id_promotion_product"  value="' . $Id_Promotion_Product . '" name="for_id_promotion_product[]" style="" readonly></td>';
                $output .= '</tr>';
                // dd($Id_Promotion_Product);

                echo $output;
            }
        }
    }

    public function Detail_Promotion_Products(Request $request)
    {
        $Id_Promotion = $request->Id_Promotion;


        $promotions_product_detail = DB::select(DB::raw("SELECT `products`.`Name_Product`,`products`.`Price`,`products`.`Img_Product`,`promotions`.`Name_Promotion`, `premium_pros`.`Name_Premium_Pro`, `premium_pros`.`Img_Premium_Pro`, `promotion_prods`.`Amount_Premium_Pro` as `Amount_Premium `, `premium_pros`.`Amount_Premium_Pro` as `Lot` 
        from `promotions`
         inner join `promotion_prods` on `promotion_prods`.`Id_Promotion` = `promotions`.`Id_Promotion` 
         inner join `premium_pros` on `premium_pros`.`Id_Premium_Pro` = `promotion_prods`.`Id_Premium_Pro` 
         inner join `products` on `promotions`.`Id_Product` = `products`.`Id_Product`
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



                $promotions = DB::select(DB::raw("SELECT
                `Name_Promotion`,
                `Name_Product`,
                `Sdate_Promotion`,
                `Edate_Promotion`,
                `promotions`.`Id_Product`,
                `promotion_prods`.`Id_Promotion`
                FROM
                `promotions`
                INNER JOIN `promotion_prods` ON `promotion_prods`.`Id_Promotion` = `promotions`.`Id_Promotion`
                INNER JOIN `premium_pros` ON `premium_pros`.`Id_Premium_Pro` = `promotion_prods`.`Id_Premium_Pro`
                INNER JOIN `products` ON `promotions`.`Id_Product` = `products`.`Id_Product` 
                 WHERE
                     `Sdate_Promotion` <= '" . $date . "'
                            AND 	`Edate_Promotion` >= '" . $date . "'  AND
                                                   `promotion_prods`.`Amount_Premium_Pro` < premium_pros.Amount_Premium_Pro
																									 GROUP BY       `Name_Promotion`,
                                                                                                     `Name_Product`,
                `Sdate_Promotion`,
                `Edate_Promotion`,
                `promotions`.`Id_Product`,
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
        $Id_Lot = $request->Id_Lot;
        $rowid = $request->rowid;
        // dd($Id_Lot);
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
            ->select('products.Id_Product', 'lot_lists.No_Lot', 'products.Amount_Preorder', 'products.Insurance', 'products.Name_Product', 'categories.Name_Category', 'brands.Name_Brand', 'brands.Id_Brand', 'products.Price', 'products.Img_Product', 'lot_lists.Amount_Lot')->where('products.Id_Product', '=',  $Id_Product)->where('lot_lists.Id_Lot', '=',  $Id_Lot)
            ->get();

        // dd($q);
        foreach ($q as  $row) {
            $Amount_Lot =  $row->Amount_Lot - $row->Amount_Preorder;
        }
        $Price = number_format($row->Price, 2);

        $output = '';
        // <img src="asset(storage)/Products_image/'.$row->Img_Product.'", alt="" width="80px" height="80px">

        foreach ($q as $row) {

            $output .= '<tr id="rowp' . $rowid . '" >';
            $output .= '<td scope="row" width="6%"><img src="http://127.0.0.1:8000/storage/Products_image/' . $row->Img_Product . '" alt="" width="80px" height="90px"></td>';

            $output .= ' <td scope="row" width="9%" ><input type="text" class="form-control text-center noHover"  value="' . $row->Name_Product . '"  style="" disabled>';

            $output .= '  <input type="hidden" class="form-control text-center noHover Id_Product_Sell "  value="' . $row->Id_Product . '" name="Id_Product_Sell[]" >';
            // $output .= ' <input type="hidden" class="form-control text-center noHover No_Product"  value="' . $No_Product . '" name="No_Product">';
            $output .= ' <input type="hidden" class="form-control text-center noHover rowp "  value="' . $rowid . '" name="rowp[]">';
            $output .= ' <input type="hidden" class="form-control text-center noHover Id_Lot_Product "  value="' . $Id_Lot . '" name="Id_Lot_Product[]">';
            $output .= ' <input type="hidden" class="form-control text-center noHover No_Lot_Product "  value="' . $row->No_Lot . '" name="No_Lot_Product[]">';
            $output .= '   </td>';
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
            $Insurance_data = 0;
            $Insurance_data = $row->Insurance;
            // dd($Insurance_data);
            // var_dump(strtotime($Insurance));
            $strStartDate = date('Y-m-d');
            $datadate = date("Y-m-d", strtotime("+" . $Insurance_data . " day", strtotime($strStartDate)));
            // dd($datadate);

            if ($row->Insurance == "0") {
                $output .= ' <td scope="row" width="5%" ><input type="text" class="form-control text-center noHover Insurance_s"  value="ไม่มีประกัน" " readonly>';
                $output .= '   <input type="hidden" class="form-control text-center noHover  Insurance"  value="' . $strStartDate . '" name="Insurance[]" >         ';
                $output .= ' </td> ';
            } else {
                $output .= ' <td scope="row" width="5%" ><input type="text" class="form-control text-center noHover Insurance_s"  value="' . $datadate . '" " readonly>

                <input type="hidden" class="form-control text-center noHover  Insurance"  value="' . $datadate . '" name="Insurance[]" >         ';
                $output .= ' </td> ';
            }

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
    public function storeSell(Request $request)
    {
        // dd($request);
        $GenId = DB::table('sells')->max('Id_Sell');
        $GenId_Sell = substr($GenId, 11, 14) + 1;
        if (is_null($GenId)) {
            $Id_Sell = "SEL" . "-" . date('Y') . date('m') . "-" . "000";
        } else {

            if ($GenId_Sell < 10) {
                $Id_Sell = "SEL" . "-" . date('Y') . date('m') . "-" . "00" . $GenId_Sell;
            } elseif ($GenId_Sell >= 10 && $GenId_Sell < 100) {
                $Id_Sell = "SEL" . "-" . date('Y') . date('m') . "-" . "0" . $GenId_Sell;
            } elseif ($GenId_Sell >= 100) {
                $Id_Sell = "SEL" . "-" . date('Y') . date('m') . "-" . $GenId_Sell;
            }
        }
    
        

        $Id = session()->get('fname');
        $id_Emp = DB::table('employees')->select('Id_Emp')->where('FName_Emp', "=", "{$Id}")->get();
        $Id_Emp = $id_Emp[0]->Id_Emp;


        $sub_payment =   str_replace(',', '', $request->payment);
        $payment_con = floatval($sub_payment);
        // $string = str_replace(',', '', $string);

        // dd($payment_con);
        $datetime = date('Y-m-d H:i:s');
        // dd($datetime);
        $sql_in_sells  = array(
            'Id_Sell' => $Id_Sell,
            'Id_Emp' => $Id_Emp,
            'Sell_Date' => $datetime,
            'Payment' => $payment_con,
            'Id_Payment' => $request->Payment_Sell,
            'Id_Member' => $request->id_member,


        );

        print_r($sql_in_sells);
        echo '<br>';
        DB::table('sells')->insert([$sql_in_sells]);
        $rowp_for = $request['rowp'];
        $rows_for = $request['Id_Promotion_Product'];
        // dd($rowp);
        $discount = Intval($request->discount_member);


        // var payment_show = payment_ - ((payment_ * discount_member_) / 100);
        $test = '';
        foreach ($rowp_for as $item => $value) {

            $in_sell_lists = array(
                'Id_Sell' => $Id_Sell,
                'No_Sell' => $value,
                'Amount_Sell' => $request['Amount_Sell'][$item],
                'Total_Price' => $request['total_cost'][$item] - (($request['total_cost'][$item] * $discount) / 100),
                'End_Insurance' => $request['Insurance'][$item],
                'Id_Lot' => $request['Id_Lot_Product'][$item],
                'Id_Product' => $request['Id_Product_Sell'][$item],
                'No_Lot' => $request['No_Lot_Product'][$item],

            );


            DB::table('sell_lists')->insert([$in_sell_lists]);
            DB::statement("UPDATE lot_lists SET Amount_Lot = Amount_Lot - '" . $request['Amount_Sell'][$item] . "' WHERE Id_Lot = '" . $request['Id_Lot_Product'][$item] . "' AND No_Lot = '" . $request['No_Lot_Product'][$item] . "'");
            // --------------------------------
        }


        foreach ($rowp_for as $item => $value) {

            if ($request['for_id_promotion_product'][$item] != '0') {
                $test =  $request['for_id_promotion_product'][$item];
                $in_promotion_prod = array(
                    'Id_Sell' => $Id_Sell,
                    'No_Sell' => $value,
                    'Id_Promotion_product' => $test
                );
                echo '<br>';
                print_r($in_promotion_prod);
                echo '<br>';
                DB::table('sell_promo_products')->insert([$in_promotion_prod]);
                // --------------------------------
            } else {
                $test = null;
            }
        }






        if ($request['for_id_promotion_pay'] != null) {
            $brand_id_promotion_pay = $request['brand_id_promotion_pay'];
            $for_id_promotion_pay = $request['for_id_promotion_pay'];
            $Id_Brand = $request['Id_Brand'];
            foreach ($for_id_promotion_pay as $item => $value) {



                foreach ($Id_Brand as $item1 => $value1) {
                    if ($value1 == $brand_id_promotion_pay[$item]) {
                        $in_sell_promo_pay = array(
                            'Id_Sell' => $Id_Sell,
                            'No_Sell' => $rowp_for[$item1],
                            'Id_Promotion_Payment' => $value,
                        );
                        echo '<br>';
                        print_r($in_sell_promo_pay);
                        echo '<br>';
                        DB::table('sell_promo_payments')->insert([$in_sell_promo_pay]);
                    }
                }
            }
        };


        // dd($request['premium_sell']);
        if ($request['Id_Premium_Pro_Sell'] != null) {
            $for_id_premium = $request['Id_Premium_Pro_Sell'];
            // dd($for_id_premium);
            foreach ($for_id_premium as $item => $value) {

                // echo '<br>';
                // print_r($update_premium);
                DB::statement("UPDATE `stminidb`.`premium_pros` SET `Amount_Premium_Pro`= `Amount_Premium_Pro` - '" . $request['premium_sell'][$item] . "' WHERE `Id_Premium_Pro` = '" . $value . "'");
                // echo '<br>';
            }
        }



        return redirect('/Sell/ShowSell');
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
