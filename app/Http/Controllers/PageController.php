<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class pageController extends Controller
{
    public function home()
    {
        return view('index');
    }

    public function course(Course $course)
    {
        return view('course', compact('course'));
    }
}