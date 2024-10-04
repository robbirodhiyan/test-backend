<?php

namespace App\Http\Controllers;

use App\Models\Epresence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EpresenceController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required|string|in:IN,OUT',
            'waktu' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $epresence = Epresence::create([
            'id_users' => Auth::id(),
            'type' => $validatedData['type'],
            'waktu' => $validatedData['waktu'],
            'is_approve' => false,
        ]);

        return response()->json(['message' => 'E-Presence record created successfully!', 'epresence' => $epresence], 201);
    }

    public function index()
    {
        $user = Auth::user();

        $epresenceData = Epresence::where('id_users', $user->id)
            ->with('user')
            ->get()
            ->groupBy(function ($item) {
                return $item->waktu->toDateString();
            });

        $formattedData = [];

        foreach ($epresenceData as $date => $items) {

            $waktuMasuk = $items->where('type', 'IN')->first();
            $waktuPulang = $items->where('type', 'OUT')->first();

            $formattedData[] = [
                'id_users' => $user->id,
                'nama_user' => $user->nama,
                'tanggal' => $date,
                'waktu_masuk' => $waktuMasuk->waktu ?? null,
                'status_masuk' => $waktuMasuk && $waktuMasuk->is_approve ? 'APPROVE' : 'REJECT',
                'waktu_pulang' => $waktuPulang->waktu ?? null,
                'status_pulang' => $waktuPulang && $waktuPulang->is_approve ? 'APPROVE' : 'REJECT',
            ];
        }

        return response()->json([
            'message' => 'Success get data',
            'data' => $formattedData
        ]);
    }

     public function approve($id)
    {
        $epresenceIn = Epresence::where('id', $id)
            ->where('type', 'IN')
            ->first();

        $epresenceOut = Epresence::where('id', $id)
            ->where('type', 'OUT')
            ->first();

        if (!$epresenceIn && !$epresenceOut) {
            return response()->json(['message' => 'No IN or OUT records found for the given ID'], 404);
        }

        if ($epresenceIn) {
            $epresenceIn->is_approve = true;
            $epresenceIn->save();
        }
        if ($epresenceOut) {
            $epresenceOut->is_approve = true;
            $epresenceOut->save();
        }

        return response()->json([
            'message' => 'IN and OUT presence approved successfully',
            'data' => [
                'in' => $epresenceIn,
                'out' => $epresenceOut
            ]
        ], 200);
    }
}
