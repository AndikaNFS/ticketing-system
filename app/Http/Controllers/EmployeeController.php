<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Employeebuild;
use App\Models\EmployeeBuilding;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $employeeit = Employee::all();
        $employeebuild = Employeebuild::all();

        return view('admin.employees.index', compact('employeebuild', 'employeeit'));
    }

    public function createIT()
    {
        return view('admin.employees.it.create');
    }
    public function createBuild()
    {
        return view('admin.employeesbuild.build.create');
    }

    public function storeIT(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'position'=>'required|string|max:255',
            'phone_number'=>'nullable|string|max:15',
            'email' => 'nullable|string|max:200',
            'is_active' => 'nullable|string|max:10',
            
            ]);

        Employee::create([
            'name' => $request->name,
            'position' => $request->position,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'is_active' => $request->is_active
        ]);

        return redirect()->route('employees.index')->with('success', 'Data berhasil di simpan!');
    }
    public function storeBuild(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'position'=>'required|string|max:255',
            'phone_number'=>'nullable|string|max:15',
            'email' => 'nullable|string|max:200',
            'is_active' => 'nullable|string|max:10',
            
            ]);


        Employeebuild::create([
            'name' => $request->name,
            'position' => $request->position,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'is_active' => $request->is_active
        ]);

        return redirect()->route('employees.index')->with('success', 'Data berhasil di simpan!');
    }

    public function editIT($id)
    {
        // $employeebuild = Employeebuild::findOrFail($id);
        $employeeit = Employee::findOrFail($id);

        return view('admin.employees.it.edit', compact('employeeit'));
    }

    public function editBuild($id)
    {
        // $employeebuild = Employeebuild::findOrFail($id);
        $employeebuild = Employeebuild::findOrFail($id);

        return view('admin.employees.build.edit', compact('employeebuild'));
    }

    public function updateIT(Request $request, Employee $employee, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'phone_number'=>'nullable|string|max:15',
            'email' => 'nullable|string|max:200',
            'is_active' => 'nullable|string|max:10',
        ]);

        $employee = Employee::findOrFail($id);

        $employee->update($validated + [
            'name' => $request->name,
            'position' => $request->position,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'is_active' => $request->is_active
        ]);

        return redirect()->route('employees.index')->with('success', 'Data berhasil update!');
    }
    public function updateBuild(Request $request, Employeebuild $employeebuild, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'phone_number'=>'nullable|string|max:15',
            'email' => 'nullable|string|max:200',
            'is_active' => 'nullable|string|max:10',
        ]);

        $employeebuild = Employeebuild::findOrFail($id);

        $employeebuild->update($validated + [
            'name' => $request->name,
            'position' => $request->position,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'is_active' => $request->is_active
        ]);

        return redirect()->route('employees.index')->with('success', 'Data berhasil update!');
    }

    public function toggleIT (Employee $employeeit)
    {
        $employeeit->update([
            'is_active' => !$employeeit->is_active
        ]);

        return back()->with('success', 'Status employee berhasil di ubah');
    }
    public function toggleBuild (Employeebuild $employeebuild)
    {
        $employeebuild->update([
            'is_active' => !$employeebuild->is_active
        ]);

        return back()->with('success', 'Status employee berhasil di ubah');
    }
}
