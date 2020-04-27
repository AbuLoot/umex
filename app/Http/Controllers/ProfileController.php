<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\User;
use App\City;
use App\Order;
use App\Country;
use App\Http\Requests;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        $user = Auth::user();

        return view('account.profile', compact('user'));
    }

    public function orders(Request $request)
    {
        $countries = Country::all();

        if ($request->session()->has('items')) {

            $items = $request->session()->get('items');
            $data_id = collect($items['products_id']);
            $products = Product::whereIn('id', $data_id->keys())->get();
        }

        return view('account.order', compact('products', 'countries'));
    }

    public function myOrders()
    {
        $user = Auth::user();
        $orders = $user->orders()->paginate(10);

        return view('account.orders', compact('user', 'orders'));
    }

    public function editProfile()
    {
        $countries = Country::all();
        $user = Auth::user();
        $cities = City::orderBy('sort_id')->get();

        // $date = [];
        // list($date['year'], $date['month'], $date['day']) = explode('-', $user->profile->birthday);

        return view('account.profile-edit', compact('user', 'cities', 'countries'));
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'surname' => 'required|min:2|max:40',
            'name' => 'required|min:2|max:40',
            'email' => 'required|email|max:255',
            'city_id' => 'required|numeric'
        ]);

        $user = Auth::user();
        $user->surname = $request->surname;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $user->profile->phone = $request->phone;
        $user->profile->city_id = $request->city_id;
        $user->profile->about = $request->about;
        if (isset($request->sex)) $user->profile->sex = $request->sex;
        $user->profile->birthday = $request->birthday;
        $user->profile->save();

        return redirect('/profile')->with('status', 'Запись обновлена!');
    }
}
