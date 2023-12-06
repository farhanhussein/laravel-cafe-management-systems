<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Food;
use App\Models\FoodChef;
use App\Models\Cart;
use App\Models\Order;

class HomeController extends Controller
{
    public function index()
    {
        $data = DB::table('food')->get();
        $data2 = DB::table('food_chefs')->get();
    
        return view("home", compact("data", "data2"));
    }

    // public function redirects()
    // {
    //     $data=food::all();
    //     $data2=foodchef::all();

    //     $usertype= Auth::user() -> usertype;
    //     if($usertype=='1')
    //     {
    //         return view('admin.adminhome');
    //     }

    //     else{
    //         $user_id=Auth::id();
    //         $count=cart::where('user_id', $user_id)->count();
    //         return view('home', compact('data', 'data2', 'count'));
    //     }
    // }
    public function redirects()
    {
        $data = DB::table('food')->get();
        $data2 = DB::table('food_chefs')->get();
    
        $usertype = Auth::user()->usertype;
        
        if ($usertype == '1') {
            return view('admin.adminhome');
        } else {
            $user_id = Auth::id();
            $count = DB::table('carts')
                        ->where('user_id', $user_id)
                        ->count();
            return view('home', compact('data', 'data2', 'count'));
        }
    }

    // public function addcart(Request $request, $id)
    // {
        
    //     if(Auth::id()){
    //         $user_id=Auth::id();
    //         $foodid=$id;
    //         $quantity=$request->quantity;
    //         $cart=new cart;
    //         $cart->user_id=$user_id;
    //         $cart->food_id=$foodid;
    //         $cart->quantity=$quantity;
    //         $cart->save();

    //         return redirect()->back();
    //     }else {
    //         return redirect('/login');
    //     }

    // }

    public function addcart(Request $request, $id)
    {
        if (Auth::id()) {
            $user_id = Auth::id();
            $foodid = $id;
            $quantity = $request->quantity;

            DB::table('carts')->insert([
                'user_id' => $user_id,
                'food_id' => $foodid,
                'quantity' => $quantity,
            ]);

            return redirect()->back();
        } else {
            return redirect('/login');
        }
    }

    // public function showcart(Request $request, $id)
    // {
    //     $count=cart::where('user_id', $id)
    //                 ->count();
    //     $data2=cart::select('*')
    //                 ->where('user_id', '=', $id)
    //                 ->get();
    //     $data=cart::where('user_id', $id)
    //                 ->join('food', 'carts.food_id', '=', 'food_id')
    //                 ->get();
    //     return view('showcart', compact('count', 'data', 'data2'));
    // }

    public function showcart(Request $request, $id)
    {
        $count = DB::table('carts')->where('user_id', $id)->count();
        
        $data2 = DB::table('carts')
                    ->select('*')
                    ->where('user_id', '=', $id)->get();

        $data = DB::table('carts')
            ->where('user_id', $id)
            ->join('food', 'carts.food_id', '=', 'food_id') 
            ->get();

        return view('showcart', compact('count', 'data', 'data2'));
    }

    // public function remove($id)
    // {
    //     $data=cart::find($id);
    //     $data->delete();
    //     return redirect()->back();
    // }

    public function remove($id)
    {
        DB::table('carts')
            ->where('id', $id)
            ->delete();
        return redirect()->back();
    }

    public function orderconfirm(Request $request)
    {
        foreach($request->foodname as $key => $foodname)
        {
            $data=new order;
            $data->foodname=$foodname;
            $data->price=$request->price[$key];
            $data->quantity=$request->quantity[$key];
            $data->name=$request->name;
            $data->phone=$request->phone;
            $data->address=$request->address;

            $data->save();
        }
        return redirect()->back();
    }
    
}
