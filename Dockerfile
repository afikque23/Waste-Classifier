# Flask + TensorFlow inference service
FROM python:3.11-slim

RUN apt-get update \
    && apt-get install -y --no-install-recommends libgomp1 \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt

# Only copy what the inference server needs
COPY app.py ./
COPY model.h5 ./
COPY class_indices.json ./
COPY label_map.json ./

ENV PORT=5000
EXPOSE 5000

CMD ["sh", "-c", "gunicorn -w 1 -b 0.0.0.0:${PORT} app:app --timeout 120"]
