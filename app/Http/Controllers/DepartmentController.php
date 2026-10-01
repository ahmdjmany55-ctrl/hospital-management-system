<?php

namespace App\Http\Controllers;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
   public function store(Request $request)
{
    $request->validate([

        'name' => 'required|unique:departments|max:255',

        'description' => 'nullable',

        'status' => 'required|boolean',

    ]);

    Department::create([

        'name' => $request->name,

        'description' => $request->description,

        'status' => $request->status,

    ]);

    return redirect('/departments')
            ->with('success','تم إضافة القسم بنجاح');
}
    public function index()
{
    $departments = Department::all();

    return view('departments.index', compact('departments'));
}

    public function create()
    {
        return view('departments.create');
    }

    public function edit(Department $department)
    {
       return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
    $request->validate([
        'name' => 'required|max:255|unique:departments,name,' . $department->id,
        'description' => 'nullable',
        'status' => 'required|boolean',
    ]);

    $department->update([
        'name' => $request->name,
        'description' => $request->description,
        'status' => $request->status,
    ]);

    return redirect('/departments')
        ->with('success', 'تم تحديث القسم بنجاح');
    }

    public function destroy(Department $department)
{
    $department->delete();

    return redirect('/departments')
            ->with('success', 'تم حذف القسم بنجاح');
}


}
