<?php

namespace App\Http\Controllers;

use App\Models\Usaha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsahaController extends Controller
{
    /**
     * Display a listing of usaha.
     */
    public function index(Request $request)
    {
        $query = Usaha::with(['creator:id,name,username,role', 'updater:id,name,username,role'])
            ->where('is_active', true);

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_usaha', 'ilike', "%{$search}%")
                    ->orWhere('nama_pemilik', 'ilike', "%{$search}%")
                    ->orWhere('kbli_kategori_nama', 'ilike', "%{$search}%")
                    ->orWhere('kecamatan_nama', 'ilike', "%{$search}%");
            });
        }

        // Filters
        if ($request->filled('kelas_usaha')) {
            $query->where('kelas_usaha', $request->input('kelas_usaha'));
        }

        if ($request->filled('cakupan_pasar')) {
            $query->where('cakupan_pasar', $request->input('cakupan_pasar'));
        }

        if ($request->filled('kecamatan_nama')) {
            $query->where('kecamatan_nama', $request->input('kecamatan_nama'));
        }

        if ($request->filled('kbli_kategori_kode')) {
            $query->where('kbli_kategori_kode', $request->input('kbli_kategori_kode'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('created_by')) {
            $query->where('created_by', $request->input('created_by'));
        }

        $sortBy = $request->input('sort_by', 'created_at');
        $sortDir = $request->input('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        $perPage = (int) $request->input('per_page', 10);

        return response()->json($query->paginate($perPage));
    }

    /**
     * Store a newly created usaha.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pemilik' => 'required|string|max:255',
            'nama_usaha' => 'required|string|max:255',
            'deskripsi_kegiatan' => 'nullable|string',
            'kbli_kategori_kode' => 'nullable|string|max:10',
            'kbli_kategori_nama' => 'nullable|string|max:255',
            'kbli_golongan_pokok_kode' => 'nullable|string|max:10',
            'kbli_golongan_pokok_nama' => 'nullable|string|max:255',
            'kbli_golongan_kode' => 'nullable|string|max:10',
            'kbli_golongan_nama' => 'nullable|string|max:255',
            'kbli_subgolongan_kode' => 'nullable|string|max:10',
            'kbli_subgolongan_nama' => 'nullable|string|max:255',
            'kbli_kelompok_kode' => 'nullable|string|max:10',
            'kbli_kelompok_nama' => 'nullable|string|max:255',
            'provinsi_kode' => 'nullable|string|max:10',
            'provinsi_nama' => 'nullable|string|max:255',
            'kabkot_kode' => 'nullable|string|max:10',
            'kabkot_nama' => 'nullable|string|max:255',
            'kecamatan_kode' => 'nullable|string|max:10',
            'kecamatan_nama' => 'nullable|string|max:255',
            'desa_kode' => 'nullable|string|max:10',
            'desa_nama' => 'nullable|string|max:255',
            'sls_kode' => 'nullable|string|max:50',
            'sls_nama' => 'nullable|string|max:255',
            'sub_sls' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'platforms' => 'nullable|array',
            'platforms.*.platform' => 'required_with:platforms|string',
            'platforms.*.nama_akun' => 'required_with:platforms|string',
            'kelas_usaha' => 'nullable|string|in:mikro,kecil,menengah,besar',
            'cakupan_pasar' => 'nullable|string|in:lokal,regional,nasional,internasional',
        ]);

        if (isset($validated['platforms'])) {
            $validated['platform_digital'] = $validated['platforms'];
            unset($validated['platforms']);
        }

        $validated['created_by'] = $request->user()->id;
        $validated['is_active'] = true;
        $validated['status'] = 'pending';

        $usaha = Usaha::create($validated);
        $usaha->load('creator:id,name,username,role');

        return response()->json([
            'message' => 'Usaha berhasil ditambahkan.',
            'data' => $usaha,
        ], 201);
    }

    /**
     * Display the specified usaha.
     */
    public function show(string $id)
    {
        $usaha = Usaha::with(['creator:id,name,username,role', 'updater:id,name,username,role'])->findOrFail($id);

        return response()->json([
            'data' => $usaha,
        ]);
    }

    /**
     * Update the specified usaha.
     */
    public function update(Request $request, string $id)
    {
        $usaha = Usaha::findOrFail($id);

        $validated = $request->validate([
            'nama_pemilik' => 'sometimes|required|string|max:255',
            'nama_usaha' => 'sometimes|required|string|max:255',
            'deskripsi_kegiatan' => 'nullable|string',
            'kbli_kategori_kode' => 'nullable|string|max:10',
            'kbli_kategori_nama' => 'nullable|string|max:255',
            'kbli_golongan_pokok_kode' => 'nullable|string|max:10',
            'kbli_golongan_pokok_nama' => 'nullable|string|max:255',
            'kbli_golongan_kode' => 'nullable|string|max:10',
            'kbli_golongan_nama' => 'nullable|string|max:255',
            'kbli_subgolongan_kode' => 'nullable|string|max:10',
            'kbli_subgolongan_nama' => 'nullable|string|max:255',
            'kbli_kelompok_kode' => 'nullable|string|max:10',
            'kbli_kelompok_nama' => 'nullable|string|max:255',
            'provinsi_kode' => 'nullable|string|max:10',
            'provinsi_nama' => 'nullable|string|max:255',
            'kabkot_kode' => 'nullable|string|max:10',
            'kabkot_nama' => 'nullable|string|max:255',
            'kecamatan_kode' => 'nullable|string|max:10',
            'kecamatan_nama' => 'nullable|string|max:255',
            'desa_kode' => 'nullable|string|max:10',
            'desa_nama' => 'nullable|string|max:255',
            'sls_kode' => 'nullable|string|max:50',
            'sls_nama' => 'nullable|string|max:255',
            'sub_sls' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'platforms' => 'nullable|array',
            'platforms.*.platform' => 'required_with:platforms|string',
            'platforms.*.nama_akun' => 'required_with:platforms|string',
            'kelas_usaha' => 'nullable|string|in:mikro,kecil,menengah,besar',
            'cakupan_pasar' => 'nullable|string|in:lokal,regional,nasional,internasional',
        ]);

        if (isset($validated['platforms'])) {
            $validated['platform_digital'] = $validated['platforms'];
            unset($validated['platforms']);
        }

        // If usaha was declined and is being edited, reset to pending
        if ($usaha->status === 'declined') {
            $validated['status'] = 'pending';
        }

        $validated['updated_by'] = $request->user()->id;

        $usaha->update($validated);
        $usaha->load(['creator:id,name,username,role', 'updater:id,name,username,role']);

        return response()->json([
            'message' => 'Usaha berhasil diperbarui.',
            'data' => $usaha,
        ]);
    }

    /**
     * Remove the specified usaha.
     */
    public function destroy(string $id)
    {
        $usaha = Usaha::findOrFail($id);
        $usaha->delete();

        return response()->json([
            'message' => 'Usaha berhasil dihapus.',
        ]);
    }

    public function verify(Request $request, string $id)
    {
        $usaha = Usaha::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,declined',
        ]);
        $usaha->update(['status' => $validated['status']]);
        return response()->json([
            'message' => 'Status usaha diperbarui.',
            'data' => $usaha,
        ]);
    }

    public function creators()
    {
        $creatorIds = Usaha::where('is_active', true)->distinct()->pluck('created_by')->filter();
        $creators = \App\Models\User::whereIn('id', $creatorIds)
            ->select('id', 'name', 'username', 'role', 'phone')
            ->orderBy('name')
            ->get();
        return response()->json($creators);
    }

    /**
     * Get dashboard statistics.
     */
    public function stats()
    {
        $usaha = Usaha::where('is_active', true)->where('status', 'approved')->get();

        $total = $usaha->count();

        $byKelas = [
            'mikro' => $usaha->where('kelas_usaha', 'mikro')->count(),
            'kecil' => $usaha->where('kelas_usaha', 'kecil')->count(),
            'menengah' => $usaha->where('kelas_usaha', 'menengah')->count(),
            'besar' => $usaha->where('kelas_usaha', 'besar')->count(),
        ];

        $byPasar = [
            'lokal' => $usaha->where('cakupan_pasar', 'lokal')->count(),
            'regional' => $usaha->where('cakupan_pasar', 'regional')->count(),
            'nasional' => $usaha->where('cakupan_pasar', 'nasional')->count(),
            'internasional' => $usaha->where('cakupan_pasar', 'internasional')->count(),
        ];

        $byKecamatan = $usaha->groupBy('kecamatan_nama')
            ->map(fn ($group) => $group->count())
            ->filter(fn ($count, $key) => $key !== '' && $key !== null)
            ->toArray();

        $byKategori = $usaha->groupBy('kbli_kategori_kode')
            ->map(fn ($group) => $group->count())
            ->filter(fn ($count, $key) => $key !== '' && $key !== null)
            ->toArray();

        $recentCount = $usaha->where('created_at', '>=', now()->subDays(30))->count();

        return response()->json([
            'total' => $total,
            'mikro' => $byKelas['mikro'],
            'kecil' => $byKelas['kecil'],
            'menengah' => $byKelas['menengah'],
            'besar' => $byKelas['besar'],
            'lokal' => $byPasar['lokal'],
            'regional' => $byPasar['regional'],
            'nasional' => $byPasar['nasional'],
            'internasional' => $byPasar['internasional'],
            'byKecamatan' => $byKecamatan,
            'byKategori' => $byKategori,
            'recentCount' => $recentCount,
        ]);
    }
}
