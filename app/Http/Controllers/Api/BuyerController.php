<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\ContactInfo;
use App\Language;
use App\SubCategory;

use App\Help;

use App\Category;
use DateTime;
use App\Banner;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;
use Auth;
use App\City;
use App\Country;
use App\Offer;
use Validator;

use Hash;
use App\Product;
use App\Cart;
use App\Shop;
use App\Wishlist;
use App\Review;
use App\Address;
use App\ChildCategory;
use App\Color;
use App\Size;
use App\ProductImage;
use Mail;
use Password;
use Illuminate\Support\Str;
use App\VendorBuyer;
use App\Order;

use App\Order_Vendor_Product;


use Spatie\Translatable\HasTranslations;
class BuyerController extends Controller   
{  
    use GeneralTrait; 
   
    public function categotries(Request $request)
    {    
        $categorytitle=$request->categoryTitle;
        if($categorytitle){
            $categotries = Category::where('name', 'LIKE', "%{$categorytitle}%")->get();
        }else{
            $categotries = Category::where('status','1')->get();    
        }
        
        foreach ($categotries as $item) {
            $title = json_decode($item->name);
            if($request->lang=="ar"){
                // dd($item->getTranslation('title','ar'));
                $item->title=$item->getTranslation('name','ar');
            }elseif($request->lang=="sw"){
                $item->title=$item->getTranslation('name','sw');
            }else{
                $item->title=$item->getTranslation('name','en');
            } 
            $item->icon="http://beautiheath.com/sub/eshop/img/category/".$item->icon;
            $item->imge="http://beautiheath.com/sub/eshop/img/category/".$item->image;
        } 
        
        
        // dd($categotries); 
        return $this -> returnDataa(
            'data',$categotries,'riuhfer'
        );
    }
    public function allproduct(Request $request)
    {
        // dd('dddd');
        if($request->categoryId !=null){
            $products = Product::where('categoryId',$request->categoryId)->get(); 
        }elseif($request->shopId !=null){
            $products = Product::where('shopId',$request->shopId)->get(); 
        }else{
            $todayDate = date("Y-m-d");
            $products = Product::where('date',$todayDate)->get();  
        }
        foreach ($products as $item) {
            // $title = json_decode($item->name);
            // $description = json_decode($item->description);
            if($request->lang=="ar"){
                 $item->name=$item->getTranslation('names','ar');
                 $item->description=$item->getTranslation('descriptions','ar');
            }elseif($request->lang=="sw"){
                $item->name=$item->getTranslation('names','sw');
                $item->description=$item->getTranslation('descriptions','sw');
            }else{
                $item->name=$item->getTranslation('names','en');
                $item->description=$item->getTranslation('descriptions','en');
            } 
            $item->cover_img="http://beautiheath.com/sub/eshop/img/product/".$item->cover_img;
            $product_image=ProductImage::where('productId',$item->id)->get(); 
            foreach ($product_image as $image) {
                $image->image="http://beautiheath.com/sub/eshop/img/product/".$image->image;
            }
            $cover_img= ProductImage::where('productId',$item->id)->first();
            $item->cover_img="http://beautiheath.com/sub/eshop/img/product/".$cover_img->image;

            $item->product_image=$product_image;
            // $item->colors=Color::where('productId',$item->id)->get(); 
            // $item->sizes=Size::where('productId',$item->id)->get();
            $ggg=json_decode($item->size);
            $item->size=$ggg;
            
            $color=json_decode($item->color);
            $item->color=$color;
            // $item->titleeeeee =$item->slug ;
            
            $user = Auth::guard('vendorsbuyers-api')->user();
            if($user){
                $wishlist=Wishlist::where('buyerId', $user->id)->where('productId', $item->id)->first();
                if($wishlist){
                    $item->wishlist=true;
                }else{
                    $item->wishlist=false;
                }
            }else{
                $item->wishlist=false;
            }    
        }
        return $this->returnDataa('data', $products,'iw7ryhfr');
    }
    
    public function allOffers(Request $request)
    {
        // dd('ddd');
        $products=[];
        $offers = Offer::get();  
        foreach ($offers as $offer) {
            $products[] = Product::where('id',$offer->productId)->first();  
        } 
        foreach ($products as $item){
            // $title = json_decode($item->name);
            // $description = json_decode($item->description);
            if($request->lang=="ar"){
                $item->name=$item->getTranslation('names','ar');
                $item->description=$item->getTranslation('descriptions','ar');
            }elseif($request->lang=="sw"){
                $item->name=$item->getTranslation('names','sw');
                $item->description=$item->getTranslation('descriptions','sw');
            }else{
                $item->name=$item->getTranslation('names','en');
                $item->description=$item->getTranslation('descriptions','en');
            } 
            
            
            
            
            
            // $item->new_price=$offer->price;
            $product_image=ProductImage::where('productId',$item->id)->get(); 
            foreach ($product_image as $image) {
                $image->image="http://beautiheath.com/sub/eshop/img/product/".$image->image;
            }
            $cover_img= ProductImage::where('productId',$item->id)->first();
            $item->cover_img="http://beautiheath.com/sub/eshop/img/product/".$cover_img->image;
            $item->product_image=$product_image;
            $ggg=json_decode($item->size);
            $item->size=$ggg;
            
            $color=json_decode($item->color);
            $item->color=$color;
            $offer = Offer::where('productId',$item->id)->first();
            $offer->image="http://beautiheath.com/sub/eshop/img/offers/".$offer->image;
            $item->offer=$offer;
            
            $user = Auth::guard('vendorsbuyers-api')->user();
            if($user){
                $wishlist=Wishlist::where('buyerId', $user->id)->where('productId', $item->id)->first();
                if($wishlist){
                    $item->wishlist=true;
                }else{
                    $item->wishlist=false;
                }
            }else{
                $item->wishlist=false;
            }   
            
        }
        return $this->returnDataa('data', $products,'iw7ryhfr');
    }
    

    public function productSearch(Request $request)
    {
        $name=$request->name;
        $products = Product::where('names', 'LIKE', "%{$name}%") ->get();  
        foreach ($products as $item) {
            // $title = json_decode($item->name);
            // $description = json_decode($item->description);
            if($request->lang=="ar"){
                 $item->name=$item->getTranslation('names','ar');
                 $item->description=$item->getTranslation('descriptions','ar');
            }elseif($request->lang=="sw"){
                $item->name=$item->getTranslation('names','sw');
                $item->description=$item->getTranslation('descriptions','sw');
            }else{
                $item->name=$item->getTranslation('names','en');
                 $item->description=$item->getTranslation('descriptions','en');
            } 
            $product_image=ProductImage::where('productId',$item->id)->get(); 
            foreach ($product_image as $image) {
                $image->image="http://beautiheath.com/sub/eshop/img/product/".$image->image;
            }
            $cover_img= ProductImage::where('productId',$item->id)->first();
            $item->cover_img="http://beautiheath.com/sub/eshop/img/product/".$cover_img->image;
            $item->product_image=$product_image;
            // $item->colors=Color::where('productId',$item->id)->get(); 
            // $item->sizes=Size::where('productId',$item->id)->get();
            $ggg=json_decode($item->size);
            $item->size=$ggg;
            
            $color=json_decode($item->color);
            $item->color=$color;
            $user = Auth::guard('vendorsbuyers-api')->user();
            if($user){
                $wishlist=Wishlist::where('buyerId', $user->id)->where('productId', $item->id)->first();
                if($wishlist){
                    $item->wishlist=true;
                }else{
                    $item->wishlist=false;
                }
            }else{
                $item->wishlist=false;
            }   
            
        }
        return $this->returnDataa('data', $products,'iw7ryhfr');
    }

    public function allProductWishLists(Request $request)
    {
        $user = Auth::guard('vendorsbuyers-api')->user();
        if(!$user)
             if(isset($request->lang)  && $request -> lang == 'en' ){
                return $this -> returnError('You must be sign in first');
            }else{
                return $this -> returnError('يجب تسجيل الدخول اولا');
            } 
        $products=[];
        $wishlists = Wishlist::where('buyerId',$user->id)->get();  
        foreach ($wishlists as $wishlist) {
            $products[] = Product::where('id',$wishlist->productId)->first();  
        } 
        foreach ($products as $item){
            // $title = json_decode($item->name);
            // $description = json_decode($item->description);
            if($request->lang=="ar"){
                 $item->name=$item->getTranslation('names','ar');
                 $item->description=$item->getTranslation('descriptions','ar');
            }elseif($request->lang=="sw"){
                $item->name=$item->getTranslation('names','sw');
                $item->description=$item->getTranslation('descriptions','sw');
            }else{
                $item->name=$item->getTranslation('names','en');
                 $item->description=$item->getTranslation('descriptions','en');
            } 
             $product_image=ProductImage::where('productId',$item->id)->get(); 
            foreach ($product_image as $image) {
                $image->image="http://findfamily.net/eshop/img/product/".$image->image;
            }
            $cover_img= ProductImage::where('productId',$item->id)->first();
            $item->cover_img="http://beautiheath.com/sub/eshop/img/product/".$cover_img->image;
            $item->product_image=$product_image;
            // $item->colors=Color::where('productId',$item->id)->get(); 
            // $item->sizes=Size::where('productId',$item->id)->get(); 
            $ggg=json_decode($item->size);
            $item->size=$ggg;
            
            $color=json_decode($item->color);
            $item->color=$color;
            
            
            if($user){
                $wishlist=Wishlist::where('buyerId', $user->id)->where('productId', $item->id)->first();
                if($wishlist){
                    $item->wishlist=true;
                }else{
                    $item->wishlist=false;
                }
            }else{
                $item->wishlist=false;
            }   
        }
        return $this->returnDataa('data', $products,'iw7ryhfr');
    }
    public function ProductCarts(Request $request)
    {
        $user = Auth::guard('vendorsbuyers-api')->user();
        if(!$user)
            if(isset($request->lang)  && $request -> lang == 'en' ){
                return $this -> returnError('You must be sign in first');
            }else{
                return $this -> returnError('يجب تسجيل الدخول اولا');
            } 
        $products=[];
        $carts = Cart::where('buyerId',$user->id)->get();  
        foreach ($carts as $item) {
            $product= Product::where('id',$item->productId)->first(); 
             if($request->lang=="ar"){
                 $product->name=$product->getTranslation('names','ar');
                 $product->description=$product->getTranslation('descriptions','ar');
            }elseif($request->lang=="sw"){
                $item->name=$item->getTranslation('names','sw');
                $item->description=$item->getTranslation('descriptions','sw');
            }else{
                $product->name=$product->getTranslation('names','en');
                 $product->description=$product->getTranslation('descriptions','en');
            } 
            $product->counter=$item->quantity;
            $products[] = $product; 
        } 
        foreach ($products as $item){
            // $title = json_decode($item->name);
            // $description = json_decode($item->description);
            if($request->lang=="ar"){
                 $item->name=$item->getTranslation('names','ar');
                 $item->description=$item->getTranslation('descriptions','ar');
            }elseif($request->lang=="sw"){
                $item->name=$item->getTranslation('names','sw');
                $item->description=$item->getTranslation('descriptions','sw');
            }else{
                $item->name=$item->getTranslation('names','en');
                 $item->description=$item->getTranslation('descriptions','en');
            } 
            $product_image=ProductImage::where('productId',$item->id)->get(); 
            foreach ($product_image as $image) {
                $image->image="http://findfamily.net/eshop/img/product/".$image->image;
            }
            $cover_img= ProductImage::where('productId',$item->id)->first();
            $item->cover_img="http://beautiheath.com/sub/eshop/img/product/".$cover_img->image;
            $item->product_image=$product_image;
            // $item->colors=Color::where('productId',$item->id)->get(); 
            // $item->sizes=Size::where('productId',$item->id)->get();
            $ggg=json_decode($item->size);
            $item->size=$ggg;
            
            $color=json_decode($item->color);
            $item->color=$color;
        }
        return $this->returnDataa('data', $products,'iw7ryhfr');
    }
    
    public function addtoCart(Request $request)
    {
        $user = Auth::guard('vendorsbuyers-api')->user();
        if(!$user)
            if(isset($request->lang)  && $request -> lang == 'en' ){
                return $this -> returnError('You must be sign in first');
            }else{
                return $this -> returnError('يجب تسجيل الدخول اولا');
            } 
        $cart_check=Cart::where('productId',$request->productId)->where('buyerId',$user->id)->first();
            // dd($cart_check);
        if($cart_check){
            $cart_check->productId    = $request->productId;
            $cart_check->buyerId    = $user->id;
            $cart_check->quantity    = $request->quantity;
            $cart_check->save();
            if(isset($request->lang)  && $request -> lang == 'en' ){
                return $this -> returnSuccessMessage('save changed ');
            }else{
                return $this -> returnSuccessMessage('تم حفظ التغيير');
            }
        }else{
            $add = new Cart;
            $add->productId    = $request->productId;
            $add->buyerId    = $user->id;
            $add->quantity    = $request->quantity;
            $add->save();
            if(isset($request->lang)  && $request -> lang == 'en' ){
                return $this -> returnSuccessMessage('Added successfully ');
            }else{
                return $this -> returnSuccessMessage('تم الإضافة');
            }
           
        }
    }
    public function removeFromCart(Request $request)
    {
        $user = Auth::guard('vendorsbuyers-api')->user();
        if(!$user)
            if(isset($request->lang)  && $request -> lang == 'en' ){
                return $this -> returnError('You must be sign in first');
            }else{
                return $this -> returnError('يجب تسجيل الدخول اولا');
            }
        $delete_cart = Cart::where('productId',$request->productId)->where('buyerId',$user->id)->first();
        if($delete_cart)
        $delete_cart->delete(); 
        if(isset($request->lang)  && $request -> lang == 'en' ){
            return $this -> returnSuccessMessage('Deleted Successfully');
        }else{
            return $this -> returnSuccessMessage('تم الحذف بنجاح');
        }
    }
    // public function ProductUpdateCarts(Request $request)
    // {
    //     $user = Auth::guard('vendorsbuyers-api')->user();
    //     if(!$user)
    //         if(isset($request->lang)  && $request -> lang == 'en' ){
    //             return $this -> returnError('You must be sign in first');
    //         }else{
    //             return $this -> returnError('يجب تسجيل الدخول اولا');
    //         } 
    //     $cart_check=Cart::where('productId',$request->productId)->where('buyerId',$user->id)->first();
    //         // dd($cart_check);
    //     if($cart_check){
                
    //             if(isset($request->lang)  && $request -> lang == 'en' ){
    //                 return $this -> returnError('Already exists');
    //             }else{
    //                 return $this->returnError('موجود بالفعل');
    //             } 
    //     }else{
            
    //         $add = new Cart;
    //         $add->productId    = $request->productId;
    //         $add->buyerId    = $user->id;
    //         $add->save();
    //         if(isset($request->lang)  && $request -> lang == 'en' ){
    //             return $this -> returnSuccessMessage('Added successfully ');
    //         }else{
    //             return $this -> returnSuccessMessage('تم الإضافة');
    //         }
           
    //     }
    // }
    public function addtoWishlists(Request $request)
    {
        $user = Auth::guard('vendorsbuyers-api')->user();
        if(!$user)
             if(isset($request->lang)  && $request -> lang == 'en' ){
                return $this -> returnError('You must be sign in first');
            }else{
                return $this -> returnError('يجب تسجيل الدخول اولا');
            } 
        $product_wishlist=Wishlist::where('productId',$request->productId)->where('buyerId',$user->id)->first();
            // dd($cart_check);
        if($product_wishlist){
            
            $product_wishlist->delete(); 
            if(isset($request->lang)  && $request -> lang == 'en' ){
                return $this -> returnSuccessMessage('Deleted Successfully');
            }else{
                return $this -> returnSuccessMessage('removed');
            }
            //  if(isset($request->lang)  && $request -> lang == 'en' ){
            //     return $this -> returnError('Already exists');
            // }else{
            //     return $this->returnError('موجود بالفعل');
            // } 
        }else{
            
            $add = new Wishlist;
            $add->productId    = $request->productId;
            $add->buyerId    = $user->id;
            $add->save();
            if(isset($request->lang)  && $request -> lang == 'en' ){
                return $this -> returnSuccessMessage('Added successfully ');
            }else{
                 return $this -> returnSuccessMessage('Added successfully');
            };
        }
    }
    public function addReview(Request $request)
    {
        $user = Auth::guard('vendorsbuyers-api')->user();
        if(!$user)
             if(isset($request->lang)  && $request -> lang == 'en' ){
                return $this -> returnError('You must be sign in first');
            }else{
                return $this -> returnError('يجب تسجيل الدخول اولا');
            } 
        
            
            $add = new Review;
            $add->productId    = $request->productId;
            $add->buyerId    = $user->id;
            $add->comment    = $request->comment;
            $add->rate    = $request->rate;
            $add->date    = $request->date;
            $add->save();
            if(isset($request->lang)  && $request -> lang == 'en' ){
                return $this -> returnSuccessMessage('Added successfully ');
            }else{
                 return $this -> returnSuccessMessage('تم الإضافة ');
            }
    }
    public function addAdress(Request $request)
    {
        // dd('fff');
        $user = Auth::guard('vendorsbuyers-api')->user();
        // dd($user);
        if(!$user)
            if(isset($request->lang)  && $request -> lang == 'en' ){
                return $this -> returnError('You must be sign in first');
            }else{
                return $this -> returnError('يجب تسجيل الدخول اولا');
            } 
            if($request->addressId==null){
                // dd('ffffff');
                $add = new Address;
                $add->buyerId    = $user->id;
                $add->address_name    = $request->address_name;
                $add->full_name    = $request->full_name;
                $add->email    = $request->email;
                $add->phone    = $request->phone;
                $add->city    = $request->city;
                $add->state   = $request->state;
                $add->full_address    = $request->full_address;
                
                $add->save();
                if(isset($request->lang)  && $request -> lang == 'en' ){
                    return $this -> returnSuccessMessage('Added successfully ');
                }else{
                     return $this -> returnSuccessMessage('تم الإضافة ');
                }
            }else{
                // dd('xxxxx');
                $edit = Address::findOrFail($request->addressId);
                $edit->address_name    = $request->address_name;
                $edit->full_name    = $request->full_name;
                $edit->email    = $request->email;
                $edit->phone    = $request->phone;
                $edit->city    = $request->city;
                $edit->state   = $request->state;
                $edit->full_address    = $request->full_address;
                
                $edit->save();
                if(isset($request->lang)  && $request -> lang == 'en' ){
                    return $this -> returnSuccessMessage('Updated successfully ');
                }else{
                     return $this -> returnSuccessMessage('تم التعديل بنجاح');
                }
            }    
    }
    public function deleteAdress(Request $request){
        $delete_adress = Address::find($request->addressId);
        if($delete_adress)
        $delete_adress->delete(); 
        if(isset($request->lang)  && $request -> lang == 'en' ){
            return $this -> returnSuccessMessage('Deleted Successfully');
        }else{
            return $this -> returnSuccessMessage('تم الحذف بنجاح');
        }
    }
    
    // public function updateAdress(Request $request)
    // {
    //     $user = Auth::guard('vendorsbuyers-api')->user();
    //     if(!$user)
    //         if(isset($request->lang)  && $request -> lang == 'en' ){
    //             return $this -> returnError('You must be sign in first');
    //         }else{
    //             return $this -> returnError('يجب تسجيل الدخول اولا');
    //         } 
            
    //         $edit = Address::findOrFail($request->addressId);
    //         $edit->address_name    = $request->address_name;
    //         $edit->full_name    = $request->full_name;
    //         $edit->email    = $request->email;
    //         $edit->phone    = $request->phone;
    //         $edit->city    = $request->city;
    //         $edit->state   = $request->state;
    //         $edit->full_address    = $request->full_address;
            
    //         $edit->save();
    //         if(isset($request->lang)  && $request -> lang == 'en' ){
    //             return $this -> returnSuccessMessage('Updated successfully ');
    //         }else{
    //              return $this -> returnSuccessMessage('تم التعديل بنجاح');
    //         }
    // }
    public function getReview(Request $request)
    {
        $reviews = Review::where('productId',$request->productId)->get();  
        foreach ($reviews as $item) {
            $buyer = VendorBuyer::where('id',$item->buyerId)->first(); 
            $buyer->photo= "http://beautiheath.com/sub/care/img/profiles/".$buyer->photo;
            $item->buyer=$buyer;
        }
        return $this->returnDataa('data', $reviews,'iw7ryhfr');
    }    
    
    public function productDetails(Request $request)
    {
        
            $products = Product::where('id',$request->productId)->first();  
        
            // $title = json_decode($products->name);
            // $description = json_decode($products->description);
            // if($request->lang=="ar"){
            //      $products->name=$title->ar;
            //      $products->description=$description->ar;
            // }else{
            //     $products->name=$title->en;
            //     $products->description=$description->en;
            // } 
            if($request->lang=="ar"){
                 $products->name=$products->getTranslation('names','ar');
                 $products->description=$products->getTranslation('descriptions','ar');
            }elseif($request->lang=="sw"){
                $products->name=$products->getTranslation('names','sw');
                $products->description=$products->getTranslation('descriptions','sw');
            }else{
                $products->name=$products->getTranslation('names','en');
                 $products->description=$products->getTranslation('descriptions','en');
            } 
            $products->cover_img="http://beautiheath.com/sub/eshop/img/product/".$products->cover_img;
            $product_image=ProductImage::where('productId',$products->id)->get(); 
            foreach ($product_image as $image) {
                $image->image="http://beautiheath.com/sub/eshop/img/product/".$image->image;
            }
            $products->product_image=$product_image;
           
            $ggg=json_decode($products->size);
            $products->size=$ggg;
            
            $color=json_decode($products->color);
            $products->color=$color;
            // $products->titleeeeee =$products->slug ;
            
            $user = Auth::guard('vendorsbuyers-api')->user();
            if($user){
                $wishlist=Wishlist::where('buyerId', $user->id)->where('productId', $products->id)->first();
                if($wishlist){
                    $products->wishlist=true;
                }else{
                    $products->wishlist=false;
                }
            }else{
                $products->wishlist=false;
            }   
        
        return $this->returnDataa('data', $products,'iw7ryhfr');
    }
    
    public function sendOrder(Request $request)
    {
        $user = Auth::guard('vendorsbuyers-api')->user();
        if(!$user)
             if(isset($request->lang)  && $request -> lang == 'en' ){
                return $this -> returnError('You must be sign in first');
            }else{
                return $this -> returnError('يجب تسجيل الدخول اولا');
            } 
            // dd($user->id);
        $add = new Order;
        $add->buyerId    = $user->id;
        $add->addressId    = $request->addressId;
        $add->payment_method    = $request->payment_method;
        // $add->notes    = $request->notes;
        $add->save();

        // dd($request->productId);
        
        $length_productId = count($request->productId);
        if($length_productId > 0)
        {
            for($i=0; $i<$length_productId; $i++)
            {                                            
                // $order_product= new Order_Product;
                // $order_product->orderId  = $add->id;                   
                // $order_product->productId  = $request->productId[$i];
                // $order_product->quantity  = $request->quantity;                   
                // $order_product->save();
                // dd($request->productId);
                $product = Product::findOrFail( $request->productId[$i]['id']);

                $order_vendor_product= new Order_Vendor_Product;
                $order_vendor_product->order_id  = $add->id;                   
                $order_vendor_product->vendor_buyer_id  = $product->vendorId;        
                $order_vendor_product->order_productId  = $product->id;  
                $order_vendor_product->price  = $request->productId[$i]['price']; 
                $order_vendor_product->currency  = $request->productId[$i]['currency']; 
                $order_vendor_product->quantity  = $request->productId[$i]['quantity'];           
                $order_vendor_product->save();
                
                $delete_product_from_cart=Cart::where('productId',$product->id)->where('buyerId',$request->buyerId)->first();
                if($delete_product_from_cart)
                {
                    $delete_product_from_cart->delete();
                }
                
            }
        }
        return $this->returnDataa('data', $add,'تم إرسال  الطلب');
        // return $this -> returnSuccessMessage('تم الإضافة');    
    }
    
    public function getBuyerOrder(Request $request)
    {
        // dd('cdskucds');
        $user = Auth::guard('vendorsbuyers-api')->user();
        if(!$user)
             if(isset($request->lang)  && $request -> lang == 'en' ){
                return $this -> returnError('You must be sign in first');
            }else{
                return $this -> returnError('يجب تسجيل الدخول اولا');
            } 
        // dd($user);
        $orders = Order::where('buyerId',$user->id)->get();  
        foreach ($orders as $item) {
            $address=Address::where('id',$item->addressId)->first();
            $item->address=$address;
            $products=[];
            $order_vendor_product = Order_Vendor_Product::where('order_id',$item->id)->get(); 
            foreach ($order_vendor_product as $_tem) {
                $vendor = VendorBuyer::findOrFail($_tem->vendor_buyer_id);
                $product_image=ProductImage::where('productId',$_tem->order_productId)->first();
                
                $product=Product::where('id',$_tem->order_productId)->first(); 
                if($request->lang=="ar"){
                    $product->name=$product->getTranslation('names','ar');
                    $product->description=$product->getTranslation('descriptions','ar');
                }elseif($request->lang=="sw"){
                    $product->name=$product->getTranslation('names','sw');
                    $product->description=$product->getTranslation('descriptions','sw');
                }else{
                    $product->name=$product->getTranslation('names','en');
                    $product->description=$product->getTranslation('descriptions','en');
                } 
                $product->price=$_tem->price;
                $product->quantity=$_tem->quantity;
                $product->currency=$_tem->currency;
                $product->vendor=$vendor;
                
               
                
                $product->cover_img="http://beautiheath.com/sub/eshop/img/product/".$product_image->image;
                
                $products[]=$product;
            }  
            // if($products){
            //     $item->products=$products;
            // }
        }   
        // dd($orders);
        return $this->returnDataa('data', $orders,'iw7ryhfr');
    }
    public function orderStatus(Request $request)
    {
        $user = Auth::guard('vendorsbuyers-api')->user();
        if(!$user)
             if(isset($request->lang)  && $request -> lang == 'en' ){
                return $this -> returnError('You must be sign in first');
            }else{
                return $this -> returnError('يجب تسجيل الدخول اولا');
            } 
        $orderstatus = Order::where('id',$request->orderId)->first();
        
        if($orderstatus){
            if($orderstatus->status=="new"){
                $orderstatus->status  = $request->status;
                $orderstatus->save();
            }else{
                 return $this->returnError('لا يمكن إلغاء الطلب الان');
            }
            
        }
        
        return $this->returnSuccessMessage('تم تغيير حالة الطلب');

    }
    public function getVendorOrder(Request $request)
    {
        
        $user = Auth::guard('vendorsbuyers-api')->user();

        // $query = DB::table('blog_posts')
        // ->join('model_names_relations', 'blog_posts.id', '=', 'model_names_relations.blog_post_id')
        // ->join('model_names', 'model_names.id','=', 'model_names_relations.model_name_id')
        // ->where('blog_posts.id', '12')
        // ->get();

        // $query = DB::table('order_vendor_product')
        // ->join('orders', 'order_vendor_product.orderId', '=', 'orders.id')
        // ->where('order_vendor_product.vendorId', '2')
        // ->get();

        // $query = DB::table('orders')
        // ->join('order_vendor_product', 'orders.id', '=', 'order_vendor_product.orderId')
        // ->where('order_vendor_product.vendorId', '2')
        // ->get();

        $userss = VendorBuyer::find(2);  
 
        dd($userss->orders);

        // dd($query);
        // $orders=[];
        // $order_vendor_product = Order_Vendor_Product::where('vendorId',2)->get(); 
        // foreach ($order_vendor_product as $item) {
        //     $orders[]= Order::where('id',$item->orderId)->first(); 
        // }
        // https://www.itsolutionstuff.com/post/laravel-many-to-many-eloquent-relationship-tutorialexample.html
        // $myorders=[];
        // dd($order_vendor_product['id']);
        // foreach ($orders as $_item) {
        //     if($_item->id){

        //     }
        //     $myorders[]= Order::where('id',$_item->id)->first(); 
        // }
        // return $this->returnDataa('data', $myorders,'iw7ryhfr');
    }
   
    public function allBuyerAddresses(Request $request)
    {
        $user = Auth::guard('vendorsbuyers-api')->user();
        $addresses = Address::where('buyerId',$request->buyerId)->get();  
        return $this->returnDataa('data', $addresses,'iw7ryhfr');
    }
    public function allshops(Request $request)
    {
        $shops = Shop::get();
        foreach ($shops as $item) {
            $item->logo="http://beautiheath.com/sub/eshop/img/shops/".$item->logo;
        }
        
        // dd($countries);
        return $this->returnDataa('data', $shops,'iw7ryhfr');
    }
     public function sendHelp(Request $request)
    {
            
            $add = new Help;
            $add->name    = $request->name;
            $add->subject    = $request->subject;
            $add->phone    = $request->phone;
            $add->email    = $request->email;
            $add->message    = $request->message;
            $add->save();
            if(isset($request->lang)  && $request -> lang == 'en' ){
                return $this -> returnSuccessMessage('Added successfully ');
            }else{
                return $this -> returnSuccessMessage('تم الإضافة');
            };
    }
    public function banners()
    {    
        $banners = Banner::get();  
        foreach ($banners as $item) {
            $item->banner="http://beautiheath.com/sub/eshop/img/banners/".$item->banner;
        }
        // dd($countries);
        return $this->returnDataa('data', $banners,'iw7ryhfr');
    }

    
    public function contactInfo()
    {    
        
        $contactinfo = ContactInfo::first();
        
        $contactinfo->logo="http://beautiheath.com/sub/eshop/assets_admin/img/settings/".$contactinfo->logo;
        $contactinfo->favicon="http://beautiheath.com/sub/eshop/img/settings/".$contactinfo->favicon;
        
        
        return $this -> returnDataa(
            'data',$contactinfo,'erifhr'
        );
    }
    public function Countries(Request $request)
    {
        $countries = Country::selection()->get();   
        // dd($countries);
        return $this->returnDataa('data', $countries,'iw7ryhfr');
    }

    public function Cities(Request $request)
    {
        $cities = City::selection()->where('countryId',$request->countryId)->get();     
        return $this->returnDataa('cities', $cities,'wfiurw');
    }

}