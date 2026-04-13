import argparse
import json
import os
from pathlib import Path

import tensorflow as tf
from tensorflow.keras.preprocessing.image import ImageDataGenerator


IMG_SIZE = (150, 150)
DEFAULT_EPOCHS = 8  # sesuai requirement: 5–10 epoch
DEFAULT_BATCH_SIZE = 32


def resolve_default_train_dir() -> str:
    """Coba beberapa kandidat folder dataset yang umum di workspace ini."""
    candidates = [
        Path("DATASET") / "TRAIN",
        Path("DATASET") / "DATASET" / "TRAIN",
        Path("dataset"),
        Path("Dataset"),
    ]
    for p in candidates:
        if p.exists() and p.is_dir():
            return str(p)
    # fallback: gunakan current dir
    return str(Path.cwd())


def build_model(input_shape=(150, 150, 3)) -> tf.keras.Model:
    """CNN sederhana untuk klasifikasi biner (sigmoid)."""
    model = tf.keras.Sequential(
        [
            # Pakai Input() sebagai layer pertama untuk menghindari warning Keras.
            tf.keras.layers.Input(shape=input_shape),
            tf.keras.layers.Conv2D(32, (3, 3), activation="relu"),
            tf.keras.layers.MaxPooling2D(2, 2),
            tf.keras.layers.Conv2D(64, (3, 3), activation="relu"),
            tf.keras.layers.MaxPooling2D(2, 2),
            tf.keras.layers.Conv2D(128, (3, 3), activation="relu"),
            tf.keras.layers.MaxPooling2D(2, 2),
            tf.keras.layers.Flatten(),
            tf.keras.layers.Dense(128, activation="relu"),
            tf.keras.layers.Dropout(0.5),
            tf.keras.layers.Dense(1, activation="sigmoid"),
        ]
    )

    model.compile(optimizer="adam", loss="binary_crossentropy", metrics=["accuracy"])
    return model


def human_label_from_folder(folder_name: str) -> str:
    """Mapping nama folder kelas ke label presentasi."""
    k = folder_name.strip().lower()
    if k in {"o", "organic", "organik"}:
        return "Organic"
    if k in {"r", "recyclable", "recycle", "daur_ulang", "daur ulang"}:
        return "Recyclable"
    return folder_name


def main() -> None:
    parser = argparse.ArgumentParser(description="Training model CNN klasifikasi sampah (Organic vs Recyclable).")
    parser.add_argument(
        "--train_dir",
        type=str,
        default=resolve_default_train_dir(),
        help="Folder training. Harus punya subfolder per kelas (mis. O/ R/ atau organic/ recyclable/).",
    )
    parser.add_argument("--epochs", type=int, default=DEFAULT_EPOCHS)
    parser.add_argument("--batch_size", type=int, default=DEFAULT_BATCH_SIZE)
    parser.add_argument("--model_out", type=str, default="model.h5")
    parser.add_argument("--class_indices_out", type=str, default="class_indices.json")
    parser.add_argument("--label_map_out", type=str, default="label_map.json")

    args = parser.parse_args()

    train_dir = Path(args.train_dir)
    if not train_dir.exists() or not train_dir.is_dir():
        raise FileNotFoundError(f"train_dir tidak ditemukan: {train_dir}")

    # ImageDataGenerator sesuai requirement:
    # - Resize ke (150,150)
    # - Normalisasi (rescale=1./255)
    # - Binary classification (class_mode='binary')
    train_datagen = ImageDataGenerator(rescale=1.0 / 255.0, validation_split=0.2)

    train_gen = train_datagen.flow_from_directory(
        str(train_dir),
        target_size=IMG_SIZE,
        batch_size=args.batch_size,
        class_mode="binary",
        subset="training",
        shuffle=True,
    )

    val_gen = train_datagen.flow_from_directory(
        str(train_dir),
        target_size=IMG_SIZE,
        batch_size=args.batch_size,
        class_mode="binary",
        subset="validation",
        shuffle=False,
    )

    # Simpan mapping kelas agar konsisten saat inferensi di Flask
    class_indices = train_gen.class_indices  # contoh: {'O': 0, 'R': 1}
    label_map = {k: human_label_from_folder(k) for k in class_indices.keys()}

    with open(args.class_indices_out, "w", encoding="utf-8") as f:
        json.dump(class_indices, f, ensure_ascii=False, indent=2)

    with open(args.label_map_out, "w", encoding="utf-8") as f:
        json.dump(label_map, f, ensure_ascii=False, indent=2)

    model = build_model(input_shape=(IMG_SIZE[0], IMG_SIZE[1], 3))

    # Train 5–10 epoch (default 8)
    # verbose=2: output ringkas per-epoch (lebih enak untuk dipantau di terminal/log)
    model.fit(train_gen, validation_data=val_gen, epochs=args.epochs, verbose=2)

    # Simpan model
    model.save(args.model_out)
    print(f"Model tersimpan ke: {args.model_out}")
    print(f"class_indices tersimpan ke: {args.class_indices_out}")
    print(f"label_map tersimpan ke: {args.label_map_out}")


if __name__ == "__main__":
    # Supaya log TensorFlow tidak terlalu berisik
    os.environ.setdefault("TF_CPP_MIN_LOG_LEVEL", "2")
    main()
