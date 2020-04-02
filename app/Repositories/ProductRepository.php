<?php

namespace App\Repositories;

use App\Models\ {
    Product,
    Cart,
    Message
};

//use Illuminate\Support\Facades\DB;

class ProductRepository
{
    /**
     * The Model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model_product;
    protected $model_cart;
    protected $model_message;


    /**
     * Create a new ProductRepository instance.
     *
     * @param  \App\Models\Product $product
     */
    public function __construct(Product $product, Cart $cart, Message $message)
    {
         $this->model_product = $product;
         $this->model_cart = $cart;
         $this->model_message = $message;
    }

    /**
     * Create a query for Products.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function funcSelect($request)
    {
        $query = $this->model_product
        //$query = Product::
       // $query = DB::table('products')->
            ->select('id', 'name', 'price', 'image');
            //->where('top9', 1);// where('top9', '=', 1)
            //->where('price', '<', 20)
            //->orderBy('price', 'asc');

            if(isset($request->top9)){

                $query->where('top9', $request->top9)->where('name', 'like', '%' . $request->search . '%');

            }
            else
            {
                $query->where('top9', 1);
            }

        return $query->get();
    }



    /**
     * Create a query for Product.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function funcSelectOne($id)
    {
        $query = $this->model_product
            ->select('id', 'name', 'price', 'image')
            ->where('id', $id);
        return $query->get();
    }


    /**
     * Store data to cart.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addCart($request)
    {   
      //Cart::create($request->all());

        $this->model_cart->name=$request->name;

        $this->model_cart->price=$request->price;

        $this->model_cart->image=$request->image;

        $this->model_cart->save();
    }


    /**
     * Add Product to cart.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function fromCart()
    {
        $query = $this->model_cart
            ->select('id', 'name', 'price', 'image');
           return $query->get();
    }


     /**
     * Clear  cart.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function clearCart()
    {   
        $this->model_cart->truncate();

    }


    /**
     * Remove single product from  cart.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function Clear($request)
    {   
      $cart= $this->model_cart->find($request->id); 

      $cart->delete();


    }


 /**
     * Mailer message contact.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function sender($request)
    {   
         // Message::create($request->all());

        $this->model_message->message=$request->message;

        $this->model_message->contact=$request->contact;

        $this->model_message->save();   

       $title='Message from - ' . date('d-m-Y H:i:s'); 
       $message='Contact: ' . $request->contact . '<br>';
       $message .='Message: ' . $request->message;
        $client = new \GuzzleHttp\Client([
           'headers' => [
               //'Authorization' => '9267585bb333341dc049321d4e74398f',
               //'Content-Type' => 'application/json',
            ]
        ]);
        $response = $client->request('GET', 'http://api.25one.com.ua/api_mail.php?email_to=' . config('app.adminemail') . '&title=' . $title . '&message=' . $message,
         [
            //...
         ]);    
        //return json_decode($response->getBody()->getContents());  
        return response()->json([
                'answer' => $response->getBody()->getContents(),
            ]);


    }



}
