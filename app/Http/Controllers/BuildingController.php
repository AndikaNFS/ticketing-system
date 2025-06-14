<?php

namespace App\Http\Controllers;

use App\Exports\BuildingExport;
use App\Models\Building;
use App\Http\Controllers\Controller;
use App\Models\ImageBuilding;
use App\Models\Outlet;
use App\Models\Pic;
use App\Models\Vendor;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        // $buildings = Building::filterStatus($status);
        $search = $request->input('search');

        $buildings = Building::when($status, function ($query) use ($status) {
            return $query->where('status', $status);
        })
        ->when($search, function ($query) use ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('ticketing', 'like', "%{$search}%")
                  ->orWhere('pic', 'like', "%{$search}%")
                  ->orWhere('problem', 'like', "%{$search}%");
            });
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();

        return view('building.tickets.index', compact('buildings', 'status', 'search'));
    }

    public function indexPic()
    {
        $pics = Pic::all();

        return view('building.pics.index', compact('pics'));
    }
    public function indexVendor()
    {
        $vendors = Vendor::all();

        return view('building.vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $outlets = Outlet::all();
        $pics = Pic::all();
        $vendors = Vendor::all();
        $user = Auth::user();

        return view('building.tickets.create', compact('outlets', 'pics', 'vendors', 'user'));
    }

    public function createVendor()
    {
        $user = Auth::user();

        return view('building.vendors.create',compact('user'));
    }
    public function createPic()
    {
        $user = Auth::user();

        return view('building.pics.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'ticketing' => 'required|string|max:255',
            'problem' => 'required|string|max:255',
            'outlet_id' => 'required|exists:outlets,id',
            'vendor_id' => 'required|exists:vendors,id',
            'status' => 'required|in:Open,OnProgress,Done,Cancel',
            'pic_id' => 'required|exists:pics,id',
            'finish_date' => 'nullable|string|max:255',
            'start_date' => 'nullable|string|max:255',
            'user' => 'required|string|max:50',
            'work_duration' => 'nullable|string|max:225',
            'description' => 'nullable|string|max:225',
            'image_buildings.*' => 'file|mimes:jpg,jpeg,png,mp4|max:20480',
        ]);

         // Generate nomor tiket: "TICK-YYYYMMDD-XXX"
        $latestTicket = Building::latest()->first();
        $nextNumber = $latestTicket ? ((int)substr($latestTicket->ticketing, -3)) + 1 : 1;
        $ticketNumber = 'MT-' . date('Ymd') . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        // dd($request->all());

        $building = Building::create([
            'ticketing' => $ticketNumber,
            'problem' => $request->problem,
            'outlet_id' => $request->outlet_id,
            'status' => $request->status,
            'user' => $request->user,
            'vendor_id' => $request->vendor_id,
            'pic_id' => $request->pic_id,
            'finish_date' => null,
            'start_date' => null,
            'work_duration' => null,
            'description' => null,
            // 'images.*' => null,
        ]);
        if ($building->finish_date) {
            $start = $building->created_at;
            $end = $building->finish_date;
            $building->work_duration = $start->diffInDays($end);
            $building->save();
        }

        if ($request->hasFile('image_buildings')) {
            foreach ($request->file('image_buildings') as $file) {
                $path =$file->store('building_images', 'public');
                // Image::create([
                //     'ticket_id' => $ticket->id,
                //     'path' => $path,
                // ]);
                $building->image_buildings()->create([
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('building.tickets.index')->with('success', 'Data berhasil disimpan!');
    
    }

    public function storeVendor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user' => 'required|string|max:50',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:255',
        ]);

        Vendor::create([
            'name' => $request->name,
            'user' => $request->user,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
        ]);

        return redirect()->route('building.vendors.index')->with('success', 'Data berhasil tersimpan');
        
    }
    public function storePic(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'no_telp' => 'nullable|string|max:255',
            'user' => 'required|string|max:50',
        ]);

        Pic::create([
            'name' => $request->name,
            'no_telp' => $request->no_telp,
            'user' => $request->user,
        ]);

        return redirect()->route('building.pics.index')->with('success', 'Data berhasil tersimpan');
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ticket = Building::where('id', $id)->get();
        // $detail = Building::with('image_building')->find($id);

        return view('building.tickets.detail', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $building = Building::findOrFail($id);
        $outlets = Outlet::all();
        $pics = Pic::all();
        $vendors = Vendor::all();

        // Cek apakah ini edit pertama kali
        if (!session()->has('edit_step_'.$id)) {
            session(['edit_step_'.$id => 1]); // Set edit pertama
        }

        return view('building.tickets.edit', compact('building', 'outlets', 'pics', 'vendors'));

    }
    
    public function editPic($id)
    {
        $pic = Pic::findOrFail($id);
        $user = Auth::user();

        return view('building.pics.edit', compact('pic', 'user'));
    }
    public function editVendor($id)
    {
        $vendor = Vendor::findOrFail($id);
        $user = Auth::user();

        return view('building.vendors.edit', compact('vendor', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Building $building, $id)
    {
        $request->validate([
            'ticketing' => 'required|string|max:255',
            'problem' => 'required|string|max:255',
            'outlet_id' => 'required|exists:outlets,id',
            'vendor_id' => 'required|exists:vendors,id',
            'status' => 'required|in:Open,InProgress,Done,Cancel',
            'pic_id' => $request->pic_id == 'Done' ? 'required|exists:pics,id' : 'required|exists:pics,id',
            'finish_date' => $request->status == 'Done' ? 'required|date' : 'nullable|date',
            'work_duration' => $request->work_duration == 'Done' ? 'required|string|max:255' : 'nullable|string|max:225',
            'start_date' => 'nullable|date',
            'desription' => 'nullable|string|max:255',
            'image_buildings.*' => 'nullable|file|mimes:jpeg,png,jpg,mp4|max:20480', // max 20MB
        ]);
        // dd($request->all());

        $building = Building::findOrFail($id);
        // $dateFinish = $request->finish_date ? Carbon::parse($request->finish_date) : null;
        // $workDuration = null;
        // $createdAt = Carbon::parse($building->created_at);
        $startDate = Carbon::parse($building->start_date);

        // Ambil finish_date dari inputan user (form edit)
        $dateFinish = $request->finish_date ? Carbon::parse($request->finish_date) : null;

        if ($dateFinish) {
            $diff = $startDate->diff($dateFinish);
            $workDuration = $diff->d . ' hari ' . $diff->h . ' jam ' . $diff->i . ' menit';
        } else {
            $workDuration = null;
        }
        $workDuration = $dateFinish ? $startDate->diff($dateFinish)->format('%d hari %h jam %i menit') : null; 


        $building->update([
            'ticketing' => $request->ticketing,
            'problem' => $request->problem,
            'outlet_id' => $request->outlet_id,
            'vendor_id' => $request->vendor_id,
            'status' => $request->status,
            'pic_id' => $request->pic_id,
            'finish_date' => $dateFinish,
            'start_date' => $request->start_date,
            'work_duration' => $workDuration,
            'description' => $request->description,
        ]);

        if ($request->hasFile('image_buildings')) {
            foreach ($request->file('image_buildings') as $file) {
                $path = $file->store('image_building/building/ticketing', 'public');
                $building->image_buildings()->create(['path' => $path]);
            }
        }

        session(['edit_step_'.$id => session('edit_step_'.$id, 1) + 1]);
         
        // Jika statusnya "OnProgress", tetap di halaman edit
        // if ($request->status == 'OnProgress') {
        //     return redirect()->back()->with('success', 'Status updated to OnProgress');
        // }

        return redirect()->route('building.tickets.index')->with('success', 'Data berhasil disimpan!');
    }

    public function updateVendor(Request $request, Vendor $vendor, $id)
    {
        $request->validate([ 
            'name' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:255',
        ]);

        $vendor = Vendor::findOrFail($id);

        $vendor->update([
            'name' => $request->name,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
        ]);

        return redirect()->route('building.vendors.index')->with('success', 'Data berhasil terupdate');
    }
    public function updatePic(Request $request, Pic $pic, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'no_telp' => 'required|string|max:255',
        ]);

        $pic = Pic::findOrFail($id);

        $pic->update([
            'name' => $request->name,
            'no_telp' => $request->no_telp,
        ]);

        return redirect()->route('building.pics.index')->with('success', 'Data berhasil terupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Building $building)
    {
        //
    }

    public function destroyImage($id)
    {
        $image = ImageBuilding::findOrFail($id);

        // Hapus file fisik
        Storage::delete('public/' . $image->path);

        // hapus dari database
        $image->delete();

        return back()->with('success', 'Gambar berhasil di hapus');
    }

     public function exportExcel()
    {
        return Excel::download(new BuildingExport, 'buildings.xlsx');
    }

    public function exportPDF()
    {
        $buildings = Building::all();
        $pdf = Pdf::loadView('building.export-pdf', compact('buildings'));
        
        return $pdf->download('RR-Building.pdf');
    }
}
