<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AnalysisController extends Controller
{
    public function home(): View
    {
        return view('home');
    }

    public function analyze(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'max:5120'], // max 5MB untuk demo
        ]);

        $file = $validated['image'];

        // Simpan file upload agar bisa ditampilkan kembali di result/history
        $storedPath = $file->store('analyses', 'public');
        $absolutePath = Storage::disk('public')->path($storedPath);

        $flaskUrl = config('services.flask.predict_url', 'http://127.0.0.1:5000/predict');

        try {
            $response = Http::timeout(60)
                ->attach('image', fopen($absolutePath, 'r'), $file->getClientOriginalName())
                ->post($flaskUrl);

            if (!$response->successful()) {
                throw new \RuntimeException('Flask API gagal: HTTP ' . $response->status());
            }

            $data = $response->json();
            if (!is_array($data) || !isset($data['prediction'], $data['confidence'])) {
                throw new \RuntimeException('Response Flask API tidak valid.');
            }

            $analysis = Analysis::create([
                'image_path' => $storedPath,
                'prediction' => (string) $data['prediction'],
                'confidence' => (float) $data['confidence'],
                'analysis_json' => $data['analysis'] ?? null,
            ]);

            return redirect()->route('result.show', ['analysis' => $analysis->id]);
        } catch (\Throwable $e) {
            // Kalau API gagal, file tetap disimpan agar user bisa coba lagi (lebih enak untuk demo).
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function result(Analysis $analysis): View
    {
        return view('result', [
            'analysis' => $analysis,
            'imageUrl' => asset('storage/' . $analysis->image_path),
        ]);
    }

    public function history(): View
    {
        $items = Analysis::query()->orderByDesc('created_at')->paginate(12);

        $total = Analysis::query()->count();
        $organic = Analysis::query()->where('prediction', 'Organic')->count();
        $recyclable = Analysis::query()->where('prediction', 'Recyclable')->count();
        $avgConfidence = (float) (Analysis::query()->avg('confidence') ?? 0);

        return view('history', [
            'items' => $items,
            'stats' => [
                'total' => $total,
                'organic' => $organic,
                'recyclable' => $recyclable,
                'avg_confidence' => $avgConfidence,
            ],
        ]);
    }

    public function team(): View
    {
        $members = config('team.members', []);
        return view('team', ['members' => $members]);
    }

    public function download(Analysis $analysis)
    {
        // PDF sederhana untuk hasil analisis
        $pdf = Pdf::loadView('pdf.analysis', [
            'analysis' => $analysis,
            'imagePath' => Storage::disk('public')->path($analysis->image_path),
        ]);

        $filename = 'analysis_' . $analysis->id . '.pdf';
        return $pdf->download($filename);
    }
}
