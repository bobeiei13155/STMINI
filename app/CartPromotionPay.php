<?php
namespace App;
use App\payment_amount;
use App\PremiumPro;
use App\premium_payments;

class CartPromotionPay{
    public $incrementing = false;
    protected $primaryKey = 'Id_Promotion';
    public $items;
    public $totalQuntity; //จำนวนสินค้าในตะกร้า
    //public  $totalPrice; //จำนวนราคารวม

    public function __construct($prevCart){
        //ตะกร้าเก่า
        
        if($prevCart !=null){
            $this->items=$prevCart->items;
            $this->totalQuantity=$prevCart->totalQuantity;

        }else{
          
        //ตะกร้าใหม่
        $this->items=[];
        $this->totalQuantity=0;

        }


    }
    public function addItem($Id_PremiumPro,$PremiumPro){

        if(array_key_exists($Id_PremiumPro,$this->items)){
            $promotionToAdd=$this->items[$Id_PremiumPro];
            $promotionToAdd['quantity']++;//เพิ่้มจำนวนสินค้านั้นๆ

        }
        else{
            $promotionToAdd=['quantity'=>1,'data'=>$PremiumPro];
        }
        
        $this->items[$Id_PremiumPro] = $promotionToAdd;
        $this->totalQuantity++;
    }

    public function updatePriceQuantity(){
        //$totalPrice=0;
        $totalQuantity=0;


        foreach($this->items as $item ){

            $totalQuantity = $totalQuantity+$item['quantity'];
        }
        $this->totalQuantity=$totalQuantity;

    }
    

}


?>