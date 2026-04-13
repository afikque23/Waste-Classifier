import io
import json
import os
from pathlib import Path
from typing import Any, Dict, Tuple

import numpy as np
import tensorflow as tf
from flask import Flask, jsonify, request
from PIL import Image


IMG_SIZE = (150, 150)
CONFIDENCE_THRESHOLD = 0.6


def load_class_mappings(
    class_indices_path: str = "class_indices.json",
    label_map_path: str = "label_map.json",
) -> Tuple[Dict[str, int], Dict[str, str]]:
    """Load mapping kelas dari hasil training.

    - class_indices: folder_name -> index (0/1)
    - label_map: folder_name -> label presentasi (Organic/Recyclable)
    """
    class_indices: Dict[str, int] = {}
    label_map: Dict[str, str] = {}

    ci = Path(class_indices_path)
    lm = Path(label_map_path)

    if ci.exists():
        with open(ci, "r", encoding="utf-8") as f:
            class_indices = json.load(f)

    if lm.exists():
        with open(lm, "r", encoding="utf-8") as f:
            label_map = json.load(f)

    # Fallback kalau file mapping belum ada
    if not class_indices:
        # Asumsi umum: O=Organic, R=Recyclable
        class_indices = {"O": 0, "R": 1}

    if not label_map:
        label_map = {"O": "Organic", "R": "Recyclable"}

    return class_indices, label_map


def preprocess_image(file_bytes: bytes) -> np.ndarray:
    """Preprocess image sama seperti training:
    - convert RGB
    - resize 150x150
    - normalisasi /255
    - tambah batch dimension
    """
    img = Image.open(io.BytesIO(file_bytes)).convert("RGB")
    img = img.resize(IMG_SIZE)

    arr = np.array(img).astype(np.float32) / 255.0
    arr = np.expand_dims(arr, axis=0)
    return arr


def predict(model: tf.keras.Model, image_batch: np.ndarray) -> Tuple[int, float, float]:
    """Return (predicted_index, confidence_predicted, prob_class1).

    Keluaran model sigmoid adalah probabilitas untuk class index 1.
    """
    prob_class1 = float(model.predict(image_batch, verbose=0)[0][0])
    predicted_index = 1 if prob_class1 >= 0.5 else 0
    confidence = prob_class1 if predicted_index == 1 else (1.0 - prob_class1)
    return predicted_index, float(confidence), prob_class1


def build_analysis(suggested_label: str, confidence: float) -> Dict[str, Any]:
    """Buat penjelasan analisis untuk kebutuhan presentasi/demo."""
    interpretation = (
        "Gambar diklasifikasikan berdasarkan fitur visual yang dipelajari (tekstur, warna, dan bentuk)."
    )

    if confidence < CONFIDENCE_THRESHOLD:
        interpretation = (
            f"Model kurang yakin (confidence < {CONFIDENCE_THRESHOLD}). "
            f"Prediksi terdekat: {suggested_label}. " + interpretation
        )

    return {
        "method": "CNN-based image classification",
        "steps": [
            "Image resized to 150x150",
            "Normalized pixel values",
            "Feature extraction using convolution layers",
            "Classification using dense layer",
        ],
        "interpretation": interpretation,
    }


def create_app() -> Flask:
    app = Flask(__name__)

    model_path = os.environ.get("MODEL_PATH", "model.h5")
    if not Path(model_path).exists():
        raise FileNotFoundError(
            f"Model tidak ditemukan: {model_path}. Jalankan training dulu (train.py) untuk membuat model.h5"
        )

    model = tf.keras.models.load_model(model_path)
    class_indices, label_map = load_class_mappings()

    # Invers mapping: index -> folder_name
    index_to_folder = {int(v): k for k, v in class_indices.items()}

    @app.get("/health")
    def healthcheck():
        return jsonify({"status": "ok"})

    @app.post("/predict")
    def predict_endpoint():
        if "image" not in request.files:
            return jsonify({"error": "Field 'image' tidak ditemukan. Kirim multipart/form-data dengan key=image."}), 400

        file = request.files["image"]
        if not file or file.filename == "":
            return jsonify({"error": "File image kosong."}), 400

        try:
            img_bytes = file.read()
            image_batch = preprocess_image(img_bytes)

            predicted_index, confidence, _prob_class1 = predict(model, image_batch)

            folder_name = index_to_folder.get(predicted_index, str(predicted_index))
            suggested_label = label_map.get(folder_name, folder_name)

            # Bonus: threshold confidence
            if confidence < CONFIDENCE_THRESHOLD:
                prediction_text = "Low confidence prediction"
            else:
                prediction_text = suggested_label

            response = {
                "prediction": prediction_text,
                "confidence": round(confidence, 4),
                "analysis": build_analysis(suggested_label=suggested_label, confidence=confidence),
            }
            return jsonify(response)

        except Exception as e:
            return jsonify({"error": str(e)}), 500

    return app


app = create_app()


if __name__ == "__main__":
    # Dev server (cukup untuk demo kampus)
    app.run(host="0.0.0.0", port=5000, debug=True)
