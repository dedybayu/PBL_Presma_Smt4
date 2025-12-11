Ini merupakan eksperimen end-to-end (E2E) testing yang dilakukan menggunakan Python Playwright pada proyek Laravel.

# Bagaimana cara menjalankan test-nya ?

1. Instal dependensi
    
    Jika anda menggunakan `uv` package manager, anda bisa menggunakan perintah berikut untuk proses instalasinya:

    ```bash
    uv init
    uv venv
    .venv\Scripts\activate
    uv sync
    ```

    Jika anda tidak memiliki [`uv`](https://docs.astral.sh/uv/), maka anda bisa menginstal dependensi secara manual dengan cara berikut:

    ```bash
    python -m venv .venv
    .venv\Scripts\activate
    pip install -r requirements.txt
    ```

2. Install browser playwright

    Playwright memerlukan browser yang diinstal terlebih dahulu agar dapat menjalankan pengujian secara otomatis. Jalankan perintah berikut:

    ```bash
    playwright install
    ```

3. Jalankan e2e testing

    Gunakan perintah berikut untuk menjalankan pengujian:

    ```bash
    pytest main.py
    ```

# Tips & Trick

1. Lakukan proses test secara otomatis dengan hanya merekam dari hasil aktivitas kita di web melalui bantuan tool **codegen**

    Untuk menjalankannya, maka bisa menggunakan perintah berikut: 

    ```bash
    playwright codegen <nama-domain-website-tanpa-http>
    ```
    
    Contoh:

    ```bash
    playwright codegen presma.dbsnetwork.my.id
    ```

    Contoh video demonstrasi:

    https://github.com/user-attachments/assets/25942e2e-af08-4d6e-9dd8-02b654bfe578


3. Jika proses testing ingin menampilkan browser yang digunakan, maka bisa menambahkan flag `--headed` pada command `pytest`

    ```bash
    pytest main.py --headed
    ```
