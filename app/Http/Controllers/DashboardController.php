<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the application dashboard with statistics.
     */
    public function index()
    {
        $totalStudents = Student::count();
        $maleStudents = Student::where('gender', 'Male')->count();
        $femaleStudents = Student::where('gender', 'Female')->count();
        $otherStudents = Student::where('gender', 'Other')->count();

        // 5 most recently registered students
        $recentStudents = Student::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalStudents',
            'maleStudents',
            'femaleStudents',
            'otherStudents',
            'recentStudents'
        ));
    }
}
