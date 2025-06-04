from fastapi import FastAPI, Request
from pydantic import BaseModel
from typing import List
import pandas as pd
from topsis import Topsis

app = FastAPI()

class MahasiswaInput(BaseModel):
    nama: str
    ipk: float
    presentasi: float
    pengalaman: int
    organisasi: float
    biaya: float

class LombaInput(BaseModel):
    bobot: List[float]  # total 5 nilai bobot
    kriteria: List[str]  # contoh: ["benefit", "benefit", ..., "cost"]
    mahasiswa: List[MahasiswaInput]


@app.post("/api/data")
async def receive_data(request: Request):
    data = await request.json()  # terima seluruh data
    lomba_data = data.get("lomba", [])
    mahasiswa_data = data.get("mahasiswa", [])

    # Bisa diproses di sini, lalu dikembalikan
    return {
        "status": "ok",
        "received_count": len(mahasiswa_data) + (1 if isinstance(lomba_data, dict) else len(lomba_data)),
        "data": {
            "lomba": lomba_data,
            "mahasiswa": mahasiswa_data
        }
    }

@app.post("/api/topsis")
async def calculate_topsis(data: LombaInput):
    # Ubah list mahasiswa ke DataFrame
    df = pd.DataFrame([{
        "Mahasiswa": m.nama,
        "IPK": m.ipk,
        "Presentasi": m.presentasi,
        "Pengalaman_Lomba": m.pengalaman,
        "Organisasi": m.organisasi,
        "Biaya": m.biaya
    } for m in data.mahasiswa])

    # Inisialisasi & jalankan TOPSIS
    topsis = Topsis(df, data.bobot, data.kriteria)
    hasil = topsis.run()

    # Convert hasil DataFrame ke list of dict
    return hasil.to_dict(orient="records")
