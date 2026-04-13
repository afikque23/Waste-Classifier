# Waste-Classifier

Demo klasifikasi sampah (Organic vs Recyclable) menggunakan CNN (TensorFlow) + Web UI (Laravel).

## Struktur
- `app.py` — Flask API: `POST /predict` (multipart form field: `image`)
- `model.h5` — model hasil training
- `laravel-app/` — aplikasi web Laravel (UI + history)
- `render.yaml` — Render Blueprint (deploy Flask + Laravel)

## Jalanin lokal (Docker)
```bash
docker compose up --build
```
- Laravel: http://localhost:8000
- Flask API: http://localhost:5000/predict

## Deploy ke Render (gratis)
Gunakan Render Blueprint dari file `render.yaml`, lalu set env var di service Laravel:
- `FLASK_PREDICT_URL` = URL service Flask + `/predict`
