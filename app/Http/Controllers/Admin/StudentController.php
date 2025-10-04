<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    // Show list of students
    public function index()
    {
        $students = Student::all();
        return view('admin.students.index', compact('students'));
    }

    // Show form to create a new student
    public function create()
    {
        return view('admin.students.create');
    }

    // Store new student
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students',
            'password' => 'required|min:6',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'bio', 'date_of_birth', 'gender', 'nationality', 'address', 'city', 'state', 'postcode', 'country', 'status']);
        $data['password'] = Hash::make($request->password);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/students'), $imageName);
            $data['image'] = $imageName;
        }

        Student::create($data);

        return redirect()->route('admin.students.index')->with('success', 'Student created successfully!');
    }

    // Show student details
    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.students.show', compact('student'));
    }

    // Show form to edit student
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.students.edit', compact('student'));
    }

    // Update student
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students,email,' . $id,
            'password' => 'nullable|min:6',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $student = Student::findOrFail($id);
        $data = $request->only(['name', 'email', 'bio', 'date_of_birth', 'gender', 'nationality', 'address', 'city', 'state', 'postcode', 'country', 'status']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/students'), $imageName);
            $data['image'] = $imageName;
        }

        // Update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $student->update($data);

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully!');
    }

    // Delete student
    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        // Delete image if exists
        if ($student->image && file_exists(public_path('uploads/students/' . $student->image))) {
            unlink(public_path('uploads/students/' . $student->image));
        }

        $student->delete();

        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully!');
    }
}
