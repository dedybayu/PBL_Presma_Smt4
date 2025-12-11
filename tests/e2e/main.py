import random
from playwright.sync_api import Playwright, sync_playwright, expect
from faker import Faker

def run(playwright: Playwright) -> None:
    fake = Faker("id_ID")

    username = fake.user_name()
    nama = fake.name()
    email = fake.email()
    nim = str(random.randint(100000000000, 999999999999))

    print(f"🔹 Data Mahasiswa yang akan ditambahkan:")
    print(f"   Username : {username}")
    print(f"   Nama     : {nama}")
    print(f"   Email    : {email}")
    print(f"   NIM      : {nim}")

    browser = playwright.chromium.launch(headless=False)
    context = browser.new_context()
    page = context.new_page()

    page.goto("https://presma.dbsnetwork.my.id/")
    page.get_by_role("link", name="Masuk").click()
    page.get_by_role("textbox", name="Username").fill("admin")
    page.get_by_role("textbox", name="Password").fill("admin123")
    page.get_by_role("textbox", name="Password").press("Enter")

    page.goto("https://presma.dbsnetwork.my.id/mahasiswa")
    page.get_by_text("Mahasiswa Dosen").click()

    page.get_by_role("button", name=" Tambah").click()
    page.locator("#username").fill(username)
    page.locator("#nim").fill(nim)
    page.locator("#nama").fill(nama)
    page.locator("#select2-mahasiswa_prodi-container").click()
    page.get_by_role("treeitem", name="D4 - Teknik Informatika").click()
    page.locator("#select2-mahasiswa_kelas-container").click()
    page.get_by_role("treeitem", name="TI - 1A").click()
    page.locator("#email").fill(email)
    page.locator("#no_tlp").fill(fake.phone_number()[:12])
    page.locator("#alamat").fill(fake.address())
    page.locator("#ipk").fill(str(round(random.uniform(2.0, 4.0), 2)))
    page.locator("#tahun_angkatan").fill("2023")
    page.locator("#password").fill("mahasiswa123")
    page.get_by_role("button", name="Simpan").click()

    notif = page.locator(".swal2-popup")
    try:
        expect(notif).to_contain_text("berhasil", timeout=5000)
        print("✅ Functional Test 5: Data Mahasiswa berhasil ditambahkan")
    except Exception as e:
        print("❌ Functional Test 5: Gagal menambahkan data Mahasiswa")
        print(f"   Detail error: {str(e)}")

    try:
        page.get_by_role("button", name="OK").click(timeout=3000)
    except:
        pass

    context.close()
    browser.close()


with sync_playwright() as playwright:
    run(playwright)
