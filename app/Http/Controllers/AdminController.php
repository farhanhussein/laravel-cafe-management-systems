<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Food;
use App\Models\Reservation;
use App\Models\FoodChef;
use App\Models\Order;


class AdminController extends Controller
{
    // public function user()
    // {
    //     $data=user::all();
    //     return view("admin.users", compact("data"));
    // }

    public function user()
    {
        $data = DB::table('users')->get();
        return view("admin.users", compact("data"));
    }

    public function store(Request $request)
    {
        $id = $request->input('id'); 

        $food = new Food();
        $food->id = $id;
        $food->title = $request->input('title');
        $food->price = $request->input('price');
        $food->description = $request->input('description');

        $food->save();

        return redirect()->route('foodmenu')->with('success', 'Food item added successfully!');
    }

    // public function deleteuser($id)
    // {
    //     $data=user::find($id);
    //     $data->delete();
    //     return redirect()->back();
    // }
    public function deleteuser($id)
    {
        DB::table('users')
            ->where('id', $id)
            ->delete();
        return redirect()->back();
    }

    public function deletemenu($id)
    {
        $data=food::find($id);
        $data->delete();

        return redirect()->back();
    }

    public function softDeleteMenu($id)
    {
        DB::table('food')
            ->where('id', $id)
            ->update(['deleted_at' => now()]);
        
        return redirect()->back();
    }

    public function foodmenu()
    {
        $data = food::all();
        return view("admin.foodmenu", compact("data"));
    }

    public function updateview(Request $request, $id)
    {
        $data=food::find($id);

        return view("admin.updateview", compact("data"));
    }

    // public function update(Request $request, $id)
    // {
    //     $data=food::find($id);
    //     $image=$request->image;
    //     $imagename = time().'.'.$image->getClientOriginalExtension();
    //         $request->image->move('foodimage', $imagename);
    //         $data->image=$imagename;
    //         $data->title=$request->title;
    //         $data->price=$request->price;
    //         $data->description=$request->description;
    //         $data->save();
    //         return redirect()->back();
    // }

    public function update(Request $request, $id)
    {
        $data = DB::table('food')->where('id', $id)->first();

        $image = $request->file('image');
        $imagename = time().'.'.$image->getClientOriginalExtension();
        $image->move('foodimage', $imagename);

        DB::table('food')->where('id', $id)->update([
            'image' => $imagename,
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
        ]);

        return redirect()->back();
    }
    

    public function upload(Request $request)
    {
        $data = new food;
        $image=$request->image;
        $imagename = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('foodimage', $imagename);
            $data->image=$imagename;
            $data->title=$request->title;
            $data->price=$request->price;
            $data->description=$request->description;
            $data->save();
            return redirect()->back();
    }

    public function reservation(Request $request)
    {
        $data = new reservation;
            $data->name=$request->name;
            $data->email=$request->email;
            $data->phone=$request->phone;
            $data->guest=$request->guest;
            $data->date=$request->date;
            $data->time=$request->time;
            $data->message=$request->message;
            $data->save();

            return redirect()->back();
    }

    public function viewreservation()
    {
        $data=reservation::all();
        
        return view("admin.adminreservation", compact("data"));
    }

    public function viewchef()
    {
        $data=foodchef::all();
        
        return view("admin.adminchef", compact("data"));
    }

    public function uploadchef(Request $request)
    {
        $data=new foodchef;
        $image=$request->image;
        $imagename = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('chefimage', $imagename);
            $data->image=$imagename;
            $data->name=$request->name;
            $data->speciality=$request->speciality;
            $data->save();
            return redirect()->back();
    }

    public function updatechef($id)
    {
        $data=foodchef::find($id);
        return view("admin.updatechef", compact("data"));
    }

    public function updatefoodchef(Request $request, $id)
    {

        $data=foodchef::find($id);

        $image=$request->image;
            if($image){

                $imagename = time().'.'.$image->getClientOriginalExtension();
                $request->image->move('chefimage', $imagename);
                $data->image=$imagename;
            }
            $data->name=$request->name;
            $data->speciality=$request->speciality;
            $data->save();

            return redirect()->back();
    }

    public function deletechef($id)
    {
        $data=foodchef::find($id);
        $data->delete();

        return redirect()->back();
    }

    public function softDeleteChef($id)
    {
        DB::table('food_chefs')
        ->where('id', $id)
        ->update([
            'deleted_at' => now()
        ]);
        
        return redirect()->back();
    }

    public function orders()
    {
        $data=order::all();
        return view('admin.orders', compact('data'));
    }

    public function search(Request $request)
    {
        $search = $request->search;
        
        // Use where() with a closure for better query organization
        $data = order::where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('foodname', 'like', '%' . $search . '%');
        })->get();  // Use get() to retrieve the results
    
        return view('admin.orders', compact('data'));
    }

}
