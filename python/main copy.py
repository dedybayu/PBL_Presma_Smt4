from fastapi import FastAPI, Request
from pydantic import BaseModel
from typing import List, Dict
import pandas as pd
from topsis import Topsis

app = FastAPI()


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


@app.get("/api/data")
def read_data():
    return {"message": "Hello from Python backend"}


@app.get("/api/topsis")
def topsis():
        # Data mahasiswa + kriteria cost
    data = {
        "Mahasiswa": ["A", "B", "C", "D"],
        "IPK": [3.8, 3.5, 3.9, 3.6],
        "Presentasi": [85, 80, 90, 88],
        "Pengalaman_Lomba": [4, 6, 3, 5],
        "Organisasi": [80, 70, 85, 75],
        "Biaya": [500, 300, 450, 350]  # Cost
    }

    df = pd.DataFrame(data)

    # Bobot kriteria (jumlah = 1.0)
    weights = [0.25, 0.2, 0.2, 0.15, 0.2]

    # Tipe kriteria (benefit/cost)
    criteria = ['benefit', 'benefit', 'benefit', 'benefit', 'cost']

    # Inisialisasi dan jalankan TOPSIS
    topsis = Topsis(df, weights, criteria)
    hasil = topsis.run()

    # Tampilkan hasil
    print(hasil)
