<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ShowCosttap()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission16')) {

                $costtap = DB::select(DB::raw("SELECT y1.Id_Product , y1.Name_Product  ,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-01')) ,0.00) as Jan,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-02')) , 0.00) as Feb,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-03')) , 0.00)as Mar,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-04')) , 0.00)as Apr,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-05')) , 0.00) as May,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-06'))  , 0.00)as Jun,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-07')) , 0.00) as Jul,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-08')) , 0.00) as Aug,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-09'))  , 0.00)as Sep,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-10'))  , 0.00)as Oct,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-11'))  , 0.00)as Nov,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-12')),0.00) as 'Dec',
                IFNULL(SUM(y2.Total_Price * (y2.yy='2021')) , 0.00) as Sum1 
         
                FROM products as y1
                LEFT JOIN
                (
                SELECT sell_lists.Id_Sell , sell_lists.No_Sell , products.Id_Product , sum(sell_lists.Total_Price)as Total_Price , sells.Sell_Date , SUBSTR(sells.Sell_Date,1,7) as yymm ,
                SUBSTR(sells.Sell_Date,1,4) as yy
                FROM sell_lists 
                JOIN sells  ON sells.Id_Sell = sell_lists.Id_Sell
                JOIN lot_lists on sell_lists.Id_Lot = lot_lists.Id_Lot and lot_lists.No_Lot  = sell_lists.No_Lot
                RIGHT JOIN   products on products.Id_Product = lot_lists.Id_Product
                GROUP BY products.Id_Product ,sell_lists.Id_Sell , sell_lists.No_Sell , products.Id_Product ,  sells.Sell_Date ,yymm ,yy
                )y2 ON y1.Id_Product = y2.Id_Product
                WHERE y1.`Status` = '0'
                GROUP BY y1.Id_Product,y1.Id_Product , y1.Name_Product
                "));

                return view("report.Report_CosttapForm")->with('costtap', $costtap);
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
    public function select_corttap(Request $request)
    {

        $Year = $request->year;
        // dd($Year);
        $costtap = DB::select(DB::raw("SELECT y1.Id_Product , y1.Name_Product  ,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-01')) , 0.00) as Jan,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-02')) , 0.00) as Feb,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-03')) , 0.00)as Mar,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-04')) , 0.00)as Apr,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-05')) , 0.00) as May,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-06'))  , 0.00)as Jun,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-07')) , 0.00) as Jul,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-08')) , 0.00) as Aug,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-09'))  , 0.00)as Sep,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-10'))  , 0.00)as Oct,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-11'))  , 0.00)as Nov,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-12')) , 0.00) as 'Dec',
      
        FROM products as y1
        LEFT JOIN
        (
        SELECT sell_lists.Id_Sell , sell_lists.No_Sell , products.Id_Product , sum(sell_lists.Total_Price)as Total_Price , sells.Sell_Date , SUBSTR(sells.Sell_Date,1,7) as yymm ,
        
        FROM sell_lists 
        JOIN sells  ON sells.Id_Sell = sell_lists.Id_Sell
        JOIN lot_lists on sell_lists.Id_Lot = lot_lists.Id_Lot and lot_lists.No_Lot  = sell_lists.No_Lot
        RIGHT JOIN   products on products.Id_Product = lot_lists.Id_Product 
        GROUP BY products.Id_Product ,sell_lists.Id_Sell , sell_lists.No_Sell , products.Id_Product ,  sells.Sell_Date ,yymm 
        )y2 ON y1.Id_Product = y2.Id_Product
        WHERE y1.`Status` = '0'
        GROUP BY y1.Id_Product,y1.Id_Product , y1.Name_Product
        "));

        $output = '';
        foreach ($costtap as $row) {
            $output .= '<tr>';
            $output .= ' <td>' . $row->Name_Product . '</td>';
            $output .= ' <td>' . number_format($row->Jan, 2) . '</td>';
            $output .= ' <td>' . number_format($row->Feb, 2) . '</td>';
            $output .= ' <td>' . number_format($row->Mar, 2) . '</td>';
            $output .= ' <td>' . number_format($row->Apr, 2) . '</td>';
            $output .= ' <td>' . number_format($row->May, 2) . '</td>';
            $output .= ' <td>' . number_format($row->Jun, 2) . '</td>';
            $output .= ' <td>' . number_format($row->Jul, 2) . '</td>';
            $output .= ' <td>' . number_format($row->Aug, 2) . '</td>';
            $output .= ' <td>' . number_format($row->Sep, 2) . '</td>';
            $output .= ' <td>' . number_format($row->Oct, 2) . '</td>';
            $output .= '<td>' . number_format($row->Nov, 2) . '</td>';
            $output .= '<td>' . number_format($row->Dec, 2) . '</td>';
            $output .= '<td>' . number_format($row->Sum1, 2) . '</td>';
            $output .= '</tr>';
        }

        echo $output;

        // dd($costtap);
    }



    public function Show_Costs()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission16')) {



                $report_costs = DB::select(DB::raw("SELECT c1.Id_Product , c1.Name_Product ,IFNULL(c2.Total_Price - ((c2.Amount_Sell + c2.Amount_Claim) * c2.Cost),0)  as profit_real , categories.Id_Category,categories.Name_Category
                FROM products c1
                LEFT JOIN 
                (
                SELECT lot_lists.Id_Lot , lot_lists.No_Lot , lot_lists.Id_Product , lot_lists.Cost ,
                sell_lists.Id_Sell , sell_lists.No_Sell , sell_lists.Amount_Sell , sell_lists.Total_Price , IFNULL(claim_lists.Amount_Claim,0) as Amount_Claim 
                FROM lot_lists
                JOIN sell_lists  ON lot_lists.Id_Lot = sell_lists.Id_Lot
                                                AND lot_lists.No_Lot = sell_lists.No_Lot
                JOIN sells ON sell_lists.Id_Sell = sells.Id_Sell
                LEFT JOIN claim_lists ON claim_lists.Id_Sell = sell_lists.Id_Sell
                                                            AND claim_lists.No_Sell = sell_lists.No_Sell
                WHERE sells.`Status` = '0'
                ) c2 ON c1.Id_Product = c2.Id_Product
                JOIN categories on categories.Id_Category = c1.Category_Id
                GROUP BY c1.Id_Product , c1.Name_Product , categories.Id_Category,categories.Name_Category"));

                $cates = DB::select(DB::raw("SELECT Id_Category,Name_Category FROM categories 
                "));


                return view("report.ReportCostForm")->with('report_costs', $report_costs)->with('cates', $cates);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }


    public function Select_Cost(Request $request)
    {


        $Sdate = $request->Sdate;
        $Edate = $request->Edate;


        if (is_null($request->cate)) {
            $report_costs = DB::select(DB::raw("SELECT c1.Id_Product , c1.Name_Product ,IFNULL(c2.Total_Price - ((c2.Amount_Sell + c2.Amount_Claim) * c2.Cost),0)  as profit_real , categories.Id_Category,categories.Name_Category
            FROM products c1
            LEFT JOIN 
            (
            SELECT lot_lists.Id_Lot , lot_lists.No_Lot , lot_lists.Id_Product , lot_lists.Cost ,
            sell_lists.Id_Sell , sell_lists.No_Sell , sell_lists.Amount_Sell , sell_lists.Total_Price , IFNULL(claim_lists.Amount_Claim,0) as Amount_Claim ,
            sell_lists.Total_Price - (lot_lists.Cost * sell_lists.Amount_Sell) as profit 
            FROM lot_lists
            JOIN sell_lists  ON lot_lists.Id_Lot = sell_lists.Id_Lot
                                            AND lot_lists.No_Lot = sell_lists.No_Lot
            JOIN sells ON sell_lists.Id_Sell = sells.Id_Sell
            LEFT JOIN claim_lists ON claim_lists.Id_Sell = sell_lists.Id_Sell
                                                        AND claim_lists.No_Sell = sell_lists.No_Sell
            LEFT JOIN claims on claims.Id_Claim = claim_lists.Id_Claim
            WHERE sells.`Status` = '0'  and  (STR_TO_DATE(sells.Sell_Date,'%Y-%m-%d')  BETWEEN '" . $Sdate . "' AND '" . $Edate . "')  
            and  (STR_TO_DATE(claims.Claim_Date,'%Y-%m-%d')  BETWEEN '" . $Sdate . "' AND '" . $Edate . "')  
            ) c2 ON c1.Id_Product = c2.Id_Product
            JOIN categories on categories.Id_Category = c1.Category_Id 
            GROUP BY c1.Id_Product , c1.Name_Product, categories.Id_Category,categories.Name_Category
    
            "));

            $cates = DB::select(DB::raw("SELECT Id_Category,Name_Category FROM categories 
            "));

            return view("report.ReportCostForm")->with('report_costs', $report_costs)->with('cates', $cates);
        } else {
            $cate = $request->cate;
            $report_costs = DB::select(DB::raw("SELECT c1.Id_Product , c1.Name_Product ,IFNULL(c2.Total_Price - ((c2.Amount_Sell + c2.Amount_Claim) * c2.Cost),0)  as profit_real , categories.Id_Category,categories.Name_Category
            FROM products c1
            LEFT JOIN 
            (
            SELECT lot_lists.Id_Lot , lot_lists.No_Lot , lot_lists.Id_Product , lot_lists.Cost ,
            sell_lists.Id_Sell , sell_lists.No_Sell , sell_lists.Amount_Sell , sell_lists.Total_Price , IFNULL(claim_lists.Amount_Claim,0) as Amount_Claim ,
            sell_lists.Total_Price - (lot_lists.Cost * sell_lists.Amount_Sell) as profit 
            FROM lot_lists
            JOIN sell_lists  ON lot_lists.Id_Lot = sell_lists.Id_Lot
                                            AND lot_lists.No_Lot = sell_lists.No_Lot
            JOIN sells ON sell_lists.Id_Sell = sells.Id_Sell
            LEFT JOIN claim_lists ON claim_lists.Id_Sell = sell_lists.Id_Sell
                                                        AND claim_lists.No_Sell = sell_lists.No_Sell
            LEFT JOIN claims on claims.Id_Claim = claim_lists.Id_Claim
            WHERE sells.`Status` = '0'  and  (STR_TO_DATE(sells.Sell_Date,'%Y-%m-%d') BETWEEN '" . $Sdate . "' AND '" . $Edate . "')  
            and  (STR_TO_DATE(claims.Claim_Date,'%Y-%m-%d') BETWEEN '" . $Sdate . "' AND '" . $Edate . "')  
            ) c2 ON c1.Id_Product = c2.Id_Product
            JOIN categories on categories.Id_Category = c1.Category_Id WHERE categories.Id_Category = '" . $cate . "'
            GROUP BY c1.Id_Product , c1.Name_Product, categories.Id_Category,categories.Name_Category
    
            "));



            $cates = DB::select(DB::raw("SELECT Id_Category,Name_Category FROM categories 
            "));
            return view("report.ReportCostForm")->with('report_costs', $report_costs)->with('cates', $cates);
            
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ShowReportSell(Request $request)
    {

        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission16')) {


                $reportsells = DB::select(DB::raw("SELECT  products.Id_Product ,products.Name_Product,sum(sell_lists.Amount_Sell) as Amount_Sell 
                FROM sell_lists 
                JOIN sells  ON sells.Id_Sell = sell_lists.Id_Sell
                JOIN lot_lists on sell_lists.Id_Lot = lot_lists.Id_Lot and lot_lists.No_Lot  = sell_lists.No_Lot
                RIGHT JOIN   products on products.Id_Product = lot_lists.Id_Product
                WHERE sells.`Status` = '0' 
                GROUP BY products.Id_Product ,products.Name_Product 

                "));





                return view("report.ReportSellForm")->with('reportsells', $reportsells);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function select_Edate(Request $request)
    {

        $Sdate = $request->Sdate;
        $Edate = $request->Edate;





        $reportsells = DB::select(DB::raw("SELECT  products.Id_Product ,products.Name_Product,sum(sell_lists.Amount_Sell) as Amount_Sell 
            FROM sell_lists 
            JOIN sells  ON sells.Id_Sell = sell_lists.Id_Sell
            JOIN lot_lists on sell_lists.Id_Lot = lot_lists.Id_Lot and lot_lists.No_Lot  = sell_lists.No_Lot
            RIGHT JOIN   products on products.Id_Product = lot_lists.Id_Product
            WHERE sells.`Status` = '0' and (STR_TO_DATE(sells.Sell_Date,'%Y-%m-%d') BETWEEN '" . $Sdate . "' AND '" . $Edate . "')
            GROUP BY products.Id_Product ,products.Name_Product ORDER BY Amount_Sell DESC
            "));




        return view("report.ReportSellForm")->with('reportsells', $reportsells);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowClaim()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission16')) {





                $reportclaims = DB::select(DB::raw("SELECT products.Id_Product,products.Name_Product, IFNULL(sum(claim_lists.Amount_Claim),0) as Amount_Claim,categories.Name_Category  
                FROM claim_lists 
                JOIN claims on claims.Id_Claim = claim_lists.Id_Claim
                JOIN lot_lists on lot_lists.Id_Lot = claim_lists.Id_Lot and lot_lists.No_Lot = claim_lists.No_Lot
                RIGHT JOIN   products on products.Id_Product = lot_lists.Id_Product
                 JOIN categories on categories.Id_Category = products.Category_Id
                GROUP BY products.Id_Product ,products.Name_Product,categories.Name_Category ORDER BY Amount_Claim ASC 

                "));

                $cates = DB::select(DB::raw("SELECT Id_Category,Name_Category FROM categories 
                "));



                return view("report.ReportClaimForm")->with('reportclaims', $reportclaims)->with('cates', $cates);
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
    public function Select_Claim(Request $request)
    {


        $Sdate = $request->Sdate;
        $Edate = $request->Edate;


        if (is_null($request->cate)) {
            $reportclaims = DB::select(DB::raw("SELECT products.Id_Product,products.Name_Product, IFNULL(sum(claim_lists.Amount_Claim),0) as Amount_Claim,categories.Name_Category  
            FROM claim_lists 
            JOIN claims on claims.Id_Claim = claim_lists.Id_Claim
            JOIN lot_lists on lot_lists.Id_Lot = claim_lists.Id_Lot and lot_lists.No_Lot = claim_lists.No_Lot
            RIGHT JOIN   products on products.Id_Product = lot_lists.Id_Product
             JOIN categories on categories.Id_Category = products.Category_Id 
             WHERE  (STR_TO_DATE(claims.Claim_Date,'%Y-%m-%d') BETWEEN '" . $Sdate . "' AND '" . $Edate . "') 
            GROUP BY products.Id_Product ,products.Name_Product,categories.Name_Category ORDER BY Amount_Claim ASC 
    
            "));



            $cates = DB::select(DB::raw("SELECT Id_Category,Name_Category FROM categories 
            "));
            return view("report.ReportClaimForm")->with('reportclaims', $reportclaims)->with('cates', $cates);
        } else {
            $cate = $request->cate;
            $reportclaims = DB::select(DB::raw("SELECT products.Id_Product,products.Name_Product, IFNULL(sum(claim_lists.Amount_Claim),0) as Amount_Claim,categories.Name_Category  
            FROM claim_lists 
            JOIN claims on claims.Id_Claim = claim_lists.Id_Claim
            JOIN lot_lists on lot_lists.Id_Lot = claim_lists.Id_Lot and lot_lists.No_Lot = claim_lists.No_Lot
            RIGHT JOIN   products on products.Id_Product = lot_lists.Id_Product
             JOIN categories on categories.Id_Category = products.Category_Id
             WHERE  (STR_TO_DATE(claims.Claim_Date,'%Y-%m-%d') BETWEEN '" . $Sdate . "' AND '" . $Edate . "')  and categories.Id_Category = '" . $cate . "'
            GROUP BY products.Id_Product ,products.Name_Product,categories.Name_Category ORDER BY Amount_Claim ASC 
    
            "));



            $cates = DB::select(DB::raw("SELECT Id_Category,Name_Category FROM categories 
            "));
            return view("report.ReportClaimForm")->with('reportclaims', $reportclaims)->with('cates', $cates);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */




    public function ShowPromotion()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission16')) {





                $reportpromotions = DB::select(DB::raw("SELECT spp.Id_Promotion_Payment,count(spp.Id_Promotion_Payment) as Count_Payment , promotionpays.Name_Promotion ,promotionpays.Id_Promotion FROM sell_lists INNER JOIN sells ON sells.Id_Sell = sell_lists.Id_Sell
                INNER JOIN sell_promo_payments spp ON sell_lists.Id_Sell = spp.Id_Sell AND sell_lists.No_Sell = spp.No_Sell
                INNER JOIN promotionpays ON spp.Id_Promotion_Payment = promotionpays.Id_Promotion
                WHERE sells.status = 0
                GROUP BY spp.Id_Promotion_Payment, promotionpays.Name_Promotion ,promotionpays.Id_Promotion;

                "));


                $reportpromotion_products = DB::select(DB::raw("SELECT spp.Id_Promotion_Product,SUM(sell_lists.Amount_Sell)*COUNT(spp.Id_Promotion_Product)as Count_Promotion ,promotions.Id_Promotion, promotions.Name_Promotion FROM sell_lists INNER JOIN sells ON sells.Id_Sell = sell_lists.Id_Sell
                 INNER JOIN sell_promo_products spp ON sell_lists.Id_Sell = spp.Id_Sell AND sell_lists.No_Sell = spp.No_Sell
                 INNER JOIN promotions ON spp.Id_Promotion_Product = promotions.Id_Promotion
                 WHERE sells.status = 0
                 GROUP BY spp.Id_Promotion_Product , promotions.Name_Promotion ,promotions.Id_Promotion;

                "));
                // $cates = DB::select(DB::raw("SELECT Id_Category,Name_Category FROM categories 
                // "));



                return view("report.ReportPromotionForm")->with('reportpromotions', $reportpromotions)->with('reportpromotion_products', $reportpromotion_products);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }
    public function Select_Promotion(Request $request)
    {


        $Sdate = $request->Sdate;
        $Edate = $request->Edate;



        $reportpromotions = DB::select(DB::raw("SELECT spp.Id_Promotion_Payment,count(spp.Id_Promotion_Payment) as Count_Payment , promotionpays.Name_Promotion,promotionpays.Id_Promotion FROM sell_lists INNER JOIN sells ON sells.Id_Sell = sell_lists.Id_Sell
        INNER JOIN sell_promo_payments spp ON sell_lists.Id_Sell = spp.Id_Sell AND sell_lists.No_Sell = spp.No_Sell
        INNER JOIN promotionpays ON spp.Id_Promotion_Payment = promotionpays.Id_Promotion
        WHERE sells.status = 0 and (STR_TO_DATE(sells.Sell_Date,'%Y-%m-%d') BETWEEN '" . $Sdate . "' AND '" . $Edate . "')
        GROUP BY spp.Id_Promotion_Payment, promotionpays.Name_Promotion ,promotionpays.Id_Promotion;

        "));


        $reportpromotion_products = DB::select(DB::raw("SELECT spp.Id_Promotion_Product,SUM(sell_lists.Amount_Sell)*COUNT(spp.Id_Promotion_Product)as Count_Promotion ,promotions.Id_Promotion, promotions.Name_Promotion FROM sell_lists INNER JOIN sells ON sells.Id_Sell = sell_lists.Id_Sell
         INNER JOIN sell_promo_products spp ON sell_lists.Id_Sell = spp.Id_Sell AND sell_lists.No_Sell = spp.No_Sell
         INNER JOIN promotions ON spp.Id_Promotion_Product = promotions.Id_Promotion
         WHERE sells.status = 0 and (STR_TO_DATE(sells.Sell_Date,'%Y-%m-%d') BETWEEN '" . $Sdate . "' AND '" . $Edate . "')
         GROUP BY spp.Id_Promotion_Product , promotions.Name_Promotion,promotions.Id_Promotion; 

        "));



        return view("report.ReportPromotionForm")->with('reportpromotions', $reportpromotions)->with('reportpromotion_products', $reportpromotion_products);
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
}
