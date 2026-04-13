<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Analysis Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        .title { font-size: 16px; font-weight: bold; margin-bottom: 6px; }
        .muted { color: #555; }
        .box { border: 1px solid #ddd; padding: 12px; border-radius: 10px; margin-top: 12px; }
        .row { margin-top: 8px; }
        ul { margin: 6px 0 0 16px; }
    </style>
</head>
<body>
    <div class="title">Waste Classification Report</div>
    <div class="muted">Organic vs Recyclable • Generated: {{ $analysis->created_at }}</div>

    <div class="box">
        <div class="row"><strong>Prediction:</strong> {{ $analysis->prediction }}</div>
        <div class="row"><strong>Confidence:</strong> {{ round(((float)$analysis->confidence) * 100, 2) }}%</div>
    </div>

    <div class="box">
        <div><strong>Image</strong></div>
        <div class="row">
            <img src="{{ $imagePath }}" style="max-width: 100%; max-height: 350px;" />
        </div>
    </div>

    @php
        $analysisObj = is_array($analysis->analysis_json) ? $analysis->analysis_json : [];
        $method = $analysisObj['method'] ?? 'CNN-based Image Classification';
        $steps = $analysisObj['steps'] ?? [
            'Image resized to 150x150',
            'Normalized pixel values',
            'Feature extraction using convolution layers',
            'Classification using dense layer',
        ];
        $interpretation = $analysisObj['interpretation'] ?? 'The system analyzes visual features such as texture, color, and shape to classify the waste.';
    @endphp

    <div class="box">
        <div><strong>Image Analysis Explanation</strong></div>
        <div class="row"><strong>Method:</strong> {{ $method }}</div>
        <div class="row"><strong>Steps:</strong>
            <ul>
                @foreach ($steps as $s)
                    <li>{{ $s }}</li>
                @endforeach
            </ul>
        </div>
        <div class="row"><strong>Interpretation:</strong> {{ $interpretation }}</div>
    </div>
</body>
</html>
