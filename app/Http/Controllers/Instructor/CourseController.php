<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Level;
use App\Models\Price;
use GuzzleHttp\Client;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
		$courses = Course::where('user_id', auth()->id())->get();
		//convertir status a letra con enum
		foreach($courses as $course) {
			$course->status_name = $course->status;
		}
        return view('instructor.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$categories = Category::all();
		$levels = Level::all();
		$prices = Price::all();

		//pasar informacion a la vista
		return view('instructor.courses.create', compact('categories', 'levels', 'prices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		 $data = $request->validate([
			'title' => 'required',
			'slug' => 'required|unique:courses',
			'category_id' => 'required|exists:categories,id',
			'level_id' => 'required|exists:levels,id',
			'price_id' => 'required|exists:prices,id',
		]);
		$data['user_id'] = auth()->user()->id;
		$course = Course::create($data);
		return redirect()->route('instructor.courses.edit', $course);

    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }

}
