<?php

namespace App\Http\Controllers;

use App\Models\InternProfile;
use Illuminate\Http\Request;
use App\Exports\ApplicantsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $allowedColumns = ['nama_lengkap', 'institusi', 'jurusan', 'stase', 'created_at', 'status'];
        $sort = $request->query('sort', 'created_at');
        $direction = $request->query('direction', 'desc');

        if (!in_array($sort, $allowedColumns)) $sort = 'created_at';
        if (!in_array($direction, ['asc', 'desc'])) $direction = 'desc';

        $query = InternProfile::with('user');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', '%' . $search . '%')
                    ->orWhere('institusi', 'LIKE', '%' . $search . '%')
                    ->orWhere('jurusan', 'LIKE', '%' . $search . '%')
                    ->orWhere('nik', 'LIKE', '%' . $search . '%')
                    ->orWhere('stase', 'LIKE', '%' . $search . '%');
            });
        }

        if ($request->has('status') && in_array($request->status, ['pending', 'accepted', 'rejected'])) {
            $query->where('status', $request->status);
        }

        $counts = [
            'all' => InternProfile::count(),
            'pending' => InternProfile::where('status', 'pending')->count(),
            'accepted' => InternProfile::where('status', 'accepted')->count(),
            'rejected' => InternProfile::where('status', 'rejected')->count(),
        ];

        $applicants = $query->orderBy($sort, $direction)
            ->paginate(10)
            ->appends($request->query());

        if ($request->ajax()) {
            return view('admin.applicants._list', compact('applicants', 'counts'))->render();
        }

        return view('admin.applicants.index', compact('applicants', 'counts'));
    }

    public function show($id)
    {
        $profile = InternProfile::with('user')->findOrFail($id);
        return view('admin.applicants.show', compact('profile'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected,pending'
        ]);

        $profile = InternProfile::findOrFail($id);
        $profile->update(['status' => $request->status]);

        $statusMsg = $request->status == 'accepted' ? 'Diterima' : 'Ditolak';
        return redirect()->route('admin.applicants.show', $id)
            ->with('success', "Status pelamar berhasil diubah menjadi: $statusMsg");
    }

    public function exportExcel()
    {
        return Excel::download(new ApplicantsExport, 'data_pelamar_magang.xlsx');
    }

    public function destroy($id)
    {
        $profile = InternProfile::findOrFail($id);
        $fileColumns = [
            'pas_foto_path',
            'cv_path',
            'transkrip_path',
            'doc_surat_lamaran_path',
            'doc_ijazah_path',
            'doc_kk_path',
            'doc_surat_ijin_path'
        ];

        foreach ($fileColumns as $column) {
            if ($profile->$column) {
                if (Storage::disk('public')->exists($profile->$column)) {
                    Storage::disk('public')->delete($profile->$column);
                }
            }
        }
        $user = $profile->user;
        $user->delete();

        return redirect()->route('admin.applicants.index')
            ->with('success', 'Akun pelamar, data biodata, dan seluruh file dokumen berhasil dihapus permanen.');
    }
}