from fastapi import FastAPI, Request
from pydantic import BaseModel
from typing import List
import pandas as pd
from topsis import Topsis

app = FastAPI()

class MahasiswaInput(BaseModel):
    mahasiswa_id: int
    ipk: float
    keahlian: int
    jumlah_prestasi: int
    kesesuaian_bidang_prestasi: int
    tingkat_lomba_prestasi: int
    poin_prestasi: float
    minat: int
    organisasi: float


class LombaInput(BaseModel):
    jumlah_anggota: int
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
        "Mahasiswa_ID": m.mahasiswa_id,
        "IPK": m.ipk,
        "Keahlian": m.keahlian,
        "Jumlah_Prestasi": m.jumlah_prestasi,
        "Kesesuaian_Bidang_Prestasi": m.kesesuaian_bidang_prestasi,
        "Tingkat_Lomba_Prestasi": m.tingkat_lomba_prestasi,
        "Poin_Prestasi": m.poin_prestasi,
        "Minat": m.minat,
        "Organisasi": m.organisasi
    } for m in data.mahasiswa])


    # Inisialisasi & jalankan TOPSIS
    topsis = Topsis(df, data.bobot, data.kriteria, data.jumlah_anggota)
    hasil = topsis.run()

    # Convert hasil DataFrame ke list of dict
    return hasil.to_dict(orient="records")
