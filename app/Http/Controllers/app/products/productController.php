<?php
namespace App\Http\Controllers\app\products;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\products\product_information;
use App\Models\suppliers\suppliers;
use App\Models\products\product_price;
use App\Models\products\product_inventory;
use App\Models\products\category;
use App\Models\wingu\file_manager;
use App\Models\products\product_category_product_information;
use App\Models\products\brand;
use App\Models\Branches;
use App\Models\tax;
use Session;
use Helper;
use Input;
use File;
use Auth;
use Wingu;
use Hr;

class productController extends Controller{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {
      return view('app.products.index');
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $categories = category::where('business_code',Auth::user()->business_code)->pluck('name', 'id');
      $suppliers = suppliers::where('business_code',Auth::user()->business_code)
               ->pluck('name','id')
               ->prepend('choose supplier','');
      $brands = brand::where('business_code',Auth::user()->business_code)->pluck('name','id')->prepend('Choose brand','');

      return view('app.products.create', compact('categories','suppliers','brands'));
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request)
   {
      $this->validate($request, [
         'product_name' => 'required',
      ]);

      $product = new product_information;
      $product->product_name = $request->product_name;
      $product->sku_code = $request->sku_code;
      $product->brand = $request->brandID;
      $product->supplierID = $request->supplierID;
      $product->category = $request->category;
      $product->active = $request->status;
      $product->track_inventory = 'Yes';
      $product->business_code = Auth::user()->business_code;
      $product->created_by = Auth::user()->user_code;
      $product->save();

      //product price
      $product_price = new product_price;
      $product_price->productID = $product->id;
      $product_price->default_price = 'Yes';
      $product_price->business_code = Auth::user()->business_code;
      $product_price->created_by = Auth::user()->user_code;
      $product_price->save();

      //product inventory
      $product_inventory = new product_inventory;
      $product_inventory->productID = $product->id;
      $product_inventory->default_inventory = 'Yes';
      $product_inventory->business_code = Auth::user()->business_code;
      $product_inventory->created_by = Auth::user()->user_code;
      $product_inventory->save();

      Session::flash('success','Product successfully added.');

      return redirect()->route('product.price', $product->id);
   }

   /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function details($id)
   {
      $details = product_information::join('business','business.id','=','product_information.business_code')
                     ->join('currency','currency.id','=','business.base_currency')
                     ->join('product_inventory','product_inventory.productID','=','product_information.id')
                     ->join('product_price','product_price.productID','=','product_information.id')
                     ->whereNull('parentID')
                     ->where('product_information.id',$id)
                     ->where('product_information.business_code', Auth::user()->business_code)
                     ->select('*','product_information.id as proID','product_information.created_by as creator')
                     ->orderBy('product_information.id','desc')
                     ->first();

                     return $details;

      return view('app.products.details.show', compact('details'));
   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($id)
   {
      $product = product_information::where('product_information.id',$id)
                     ->where('product_information.business_code',Auth::user()->business_code)
                     ->select('*','product_information.id as productID', 'product_information.product_name as productName')
                     ->first();

      $productID = $id;

      //category
      $category = category::where('business_code',Auth::user()->business_code)->pluck('name','name')->prepend('--Please choose an option--','');

      $suppliers = suppliers::where('business_code',Auth::user()->business_code)
                           ->pluck('name','id')
                           ->prepend('choose supplier','');

      $brands = brand::where('business_code',Auth::user()->business_code)->pluck('name','name')->prepend('--Please choose an option--','');

      return view('app.products.edit', compact('product','productID','suppliers','brands','category'));
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
      $this->validate($request, [
         'product_name' => 'required',
      ]);

      $product = product_information::where('id',$id)->where('business_code',Auth::user()->business_code)->first();

      if($product->product_name != $request->product_name || $product->url == ""){
         $check = product_information::where('product_name',$request->product_name)->count();
         if ($check > 1) {
               $product->url = Helper::seoUrl($request->product_name).'-'.Helper::generateRandomString(4);
         }else{
               $product->url = Helper::seoUrl($request->product_name);
         }
      }
      $product->product_name = $request->product_name;
      $product->sku_code = $request->sku_code;
      $product->brand = $request->brandID;
      $product->supplierID = $request->supplierID;
      $product->category = $request->category;
      $product->status = $request->status;
      $product->business_code = Auth::user()->business_code;
      $product->updated_by = Auth::user()->user_code;
      $product->save();

      Session::flash('success','Product successfully updated !');

      return redirect()->back();
   }


   /**
    * product description
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function description($id){
      $product = product_information::where('id',$id)->where('business_code',Auth::user()->business_code)->first();
      $productID = $id;
      return view('app.products.description', compact('product','productID'));
   }


   /**
   * update product description
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function description_update(Request $request,$id){

      $product = product_information::where('id',$id)->where('business_code',Auth::user()->business_code)->first();
      $product->short_description = $request->short_description;
      $product->description = $request->description;
      $product->business_code = Auth::user()->business_code;
      $product->updated_by = Auth::user()->user_code;
      $product->save();

      Session::flash('success','Item description updated successfully');

      return redirect()->back();
   }


   /**
 * product price
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function price($id)
   {
      $mainBranch = branches::where('businessID',Auth::user()->business_code)->first();
      $product = product_information::where('id',$id)->where('business_code',Auth::user()->business_code)->first();
      $defaultPrice = product_price::where('productID', $id)->where('business_code', Auth::user()->business_code)->where('default_price','Yes')->first();
      $prices = product_price::where('productID', $id)->where('business_code', Auth::user()->business_code)->get();
      $taxes = tax::where('businessID',Auth::user()->business_code)->get();
      $outlets = branches::where('businessID',Auth::user()->business_code)->get();
      $productID = $id;

      return view('app.products.price', compact('prices','taxes','productID','product','outlets','defaultPrice','mainBranch'));
   }


   /**
   * Update product price
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function price_update(Request $request, $id)
   {
      $this->validate($request, array(
         'buying_price'=>'required',
         'selling_price'=>'required'
      ));


      $price = product_price::where('id',$id)->where('business_code',Auth::user()->business_code)->first();

      $price->buying_price = $request->input('buying_price');
      $price->taxID = $request->input('taxID');
      $price->selling_price = $request->input('selling_price');
      $price->offer_price = $request->offer_price;

      $price->save();

      session::flash('success','You have successfully edited item price!');

      return redirect()->back();
   }


   /**
 * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function destroy($id)
   {
      //check product in invoice
      $invoice = invoice_products::where('productID',$id)->count();

      if($invoice == 0){
         //delete image from folder/directory
         $check_image = file_manager::where('fileID',$id)->where('business_code', Auth::user()->business_code)->where('folder','products')->count();

         if($check_image > 0){
               //directory
               $directory = base_path().'/storage/files/business/'.Wingu::business(Auth::user()->business_code)->primary_email.'/finance/products/';
               $images = file_manager::where('fileID',$id)->where('business_code', Auth::user()->business_code)->where('folder','products')->get();
               foreach($images as $image){
               if (File::exists($directory)) {
                  unlink($directory.$image->file_name);
               }
               $image->delete();
               }
         }

         product_information::where('id', $id)->where('business_code', Auth::user()->business_code)->delete();
         product_inventory::where('productID', $id)->where('business_code', Auth::user()->business_code)->delete();
         //delete categories
         $categories = product_category_product_information::where('productID',$id)->get();
         foreach($categories as $category){
            product_category_product_information::find($category->id)->delete();
         }

         //delete tags
         $tags = product_tag::where('product_id',$id)->get();
         foreach($tags as $tag){
            product_tag::find($tag->id)->delete();
         }

         //delete price
         product_price::where('productID', $id)->where('business_code', Auth::user()->business_code)->delete();

         Session::flash('success', 'The Item was successfully deleted !');

         return redirect()->back();

      }else{
         Session::flash('error','You have recorded transactions for this product. Hence, this product cannot be deleted.');
         return redirect()->back();
      }
   }

   /**
   * get product price via ajax
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function productPrice(Request $request){
		return json_encode(product_price::where('productID', $request->product)->first());
   }

   public function express_store(Request $request){
      $primary = new customers;
		$primary->customer_name = $request->customer_name;
      $primary->business_code = Auth::user()->business_code;
      $primary->created_by = Auth::user()->user_code;
		$primary->save();

		$address = new address;
		$address->customerID = $primary->id;
		$address->save();

   }

   public function express_list(Request $request)
   {
      $accounts = product_information::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get(['id', 'product_name as text']);
      return ['results' => $accounts];
   }
}
