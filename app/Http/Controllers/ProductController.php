<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{

    Repositories\ProductRepository,
    Models\Product,
    Http\Requests\CartRequest,
    Http\Requests\MailerRequest

};

class ProductController extends Controller
{

    /**
     * The Model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProductRepository $repository)
    //public function __construct()
    {
        //$this->middleware('auth');
        $this->repository=$repository;
    }

    /**
     * Show the application home-page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    //public function index(Request $request, ProductRepository $repository)
    public function index(Request $request)
    {
        //$products=$repository->funcSelect($request);
        $products=$this->repository->funcSelect($request);

       // Ajax response
        if ($request->ajax()) {
            return response()->json([
                'table' => view("product.brick-standard", ['products' => $products])->render(),
            ]);
        } 

// Submit  response
        return view('product.index',['products'=>$products]);
    }
    
 /**
     * Show the application product-page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function product($id, Product $model_product)
    {
         //$product=$this->repository->funcSelectOne($id);
        $product=$model_product->find($id);

        return view('product.product', compact('product'));
    }

     /**
     * Show the application cart-page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function cart(Request $request)
    {
        $carts=$this->repository->fromCart();

        // Ajax response
        if ($request->ajax()) {
            return response()->json([
                'table' => view("product.cart-standard", ['carts' => $carts])->render(),
            ]);
        } 



        return view('product.cart', compact('carts'));
    }

 /**
     * Store data to cart.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function toCart(CartRequest $request)
    {   
        $this->repository->addCart($request);


        return redirect(route('cart'));
    }

    /**
     * Clear  cart.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function clearAll(Request $request)
    {   
        $this->repository->clearCart();

         // Ajax response
        if ($request->ajax()) {
            return response()->json();
        } 


        return redirect(route('cart'));
    }

    /**
     * Remove single product from  cart.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function clear(Request $request)
    {   
        $this->repository->Clear($request); // $request->id;


    }

 /**
     * Mailer message contact.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function mailer(MailerRequest $request)
    {   
         if(isset($request->validator) && $request->validator->fails()) //if you need validator->errors() in Controller
        {
            return json_encode($request->validator->errors());
        }


       return $this->repository->sender($request); 


    }


}
