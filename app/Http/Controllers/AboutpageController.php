<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use App\Models\Members;
use App\Models\Testimonials;
use Illuminate\Http\Request;

class AboutpageController extends Controller
{
    public function index()
    {
        $testimonials=Testimonials::where('status','active')->latest()->take(4)->get();
        $brands=Brands::latest()->take(5)->get();
        $members=Members::latest()->take(3)->get();

        return view('about',compact('testimonials','brands','members'));
    }

}
