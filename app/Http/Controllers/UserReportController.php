<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf; // Import PDF

class UserReportController extends Controller
{
    /**
     * Tampilkan Dashboard Statistik
     */
    public function index()
    {
        $user = Auth::user();
        $stats = [
            'diajukan' => $user->reports()->where('status', 'diajukan')->count(),
            'diterima' => $user->reports()->where('status', 'diterima')->count(),
            'ditolak'  => $user->reports()->where('status', 'ditolak')->count(),
            'selesai'  => $user->reports()->where('status', 'selesai')->count(),
        ];
        return view('dashboard', compact('stats'));
    }

    /**
     * Tampilkan List Laporan Milik User
     */
    public function myReports()
    {
        $reports = Auth::user()->reports()->latest()->paginate(10);
        return view('user.reports.index', compact('reports'));
    }

    /**
     * Tampilkan Form Buat Laporan Baru
     */
    public function create()
    {
        return view('user.reports.create');
    }

    /**
     * Simpan Laporan Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'incident_date' => 'required|date',
            'location' => 'required|string|max:255',
            'image' => 'required|image|max:2048', 
        ]);

        $imagePath = $request->file('image')->store('reports', 'public');

        Auth::user()->reports()->create([
            'title' => $request->title,
            'description' => $request->description,
            'incident_date' => $request->incident_date,
            'location' => $request->location,
            'image_path' => $imagePath,
            'status' => 'diajukan',
        ]);

        return redirect()->route('user.reports.index')->with('success', 'Laporan berhasil dikirim!');
    }

    /**
     * Tampilkan detail laporan (Read-Only)
     */
    public function show(Report $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }
        return view('user.reports.show', compact('report'));
    }

    /**
     * Tampilkan form edit laporan
     */
    public function edit(Report $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }
        if ($report->status !== 'diajukan') {
            return redirect()->route('user.reports.index')->with('error', 'Laporan ini tidak dapat diedit karena sudah diproses oleh admin.');
        }
        return view('user.reports.edit', compact('report'));
    }

    /**
     * Update laporan di database
     */
    public function update(Request $request, Report $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }
        if ($report->status !== 'diajukan') {
            return redirect()->route('user.reports.index')->with('error', 'Laporan ini tidak dapat diedit.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'incident_date' => 'required|date',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048', 
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($report->image_path);
            $validated['image_path'] = $request->file('image')->store('reports', 'public');
        }

        $report->update($validated);

        return redirect()->route('user.reports.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    /**
     * Hapus laporan
     */
    public function destroy(Report $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }
        if ($report->status !== 'diajukan') {
            return redirect()->route('user.reports.index')->with('error', 'Laporan ini tidak dapat dihapus.');
        }

        Storage::disk('public')->delete($report->image_path);
        $report->delete();

        return redirect()->route('user.reports.index')->with('success', 'Laporan berhasil dihapus.');
    }

    /**
     * Export laporan ke PDF berdasarkan rentang tanggal.
     */
    public function exportPDF(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $reports = Auth::user()->reports()
                        ->whereBetween('incident_date', [$startDate, $endDate])
                        ->latest() 
                        ->get();
        
        $data = [
            'reports' => $reports,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];

        $pdf = Pdf::loadView('user.reports.pdf', $data);
        
        $fileName = 'laporan-pantude-' . $startDate . '-' . $endDate . '.pdf';
        
        return $pdf->stream($fileName); 
    }
}