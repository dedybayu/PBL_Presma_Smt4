from fastapi import FastAPI, Request
from pydantic import BaseModel
from typing import List, Dict

app = FastAPI()

@app.post("/api/data")
async def receive_data(request: Request):
    data = await request.json()  # terima seluruh data
    lomba_data = data.get("lomba", [])

    # Bisa diproses di sini, lalu dikembalikan
    return {
        "status": "ok",
        "received_count": len(lomba_data),
        "data": lomba_data  # atau hasil olahan
    }

@app.get("/api/data")
def read_data():
    return {"message": "Hello from Python backend"}