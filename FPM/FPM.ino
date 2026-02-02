// Library yang diperlukan untuk ESP8266, WiFi, HTTP, fingerprint sensor, serial software, JSON, LCD I2C, dan Wire
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <Adafruit_Fingerprint.h>
#include <SoftwareSerial.h>
#include <ArduinoJson.h>
#include <LiquidCrystal_I2C.h>
#include <Wire.h>
#include <RTClib.h>
#include <time.h>
#include <ESP8266HTTPClient.h>

//=========================================== User Konfig ===========================================
// Konfigurasi LCD I2C dengan alamat 0x27 dan ukuran 16x2
LiquidCrystal_I2C lcd(0x27, 16, 2); //0x27 adalah alamat IIC, g
// Konfigurasi WiFi: SSID dan password
const char* ssid = "Note10s"; //Nama Wifi
const char* password = "fpm211202"; // Password Wifi
// URL server untuk komunikasi HTTP
String url_server = "http:// 10.43.134.236"; // IP address atau Domain server tanpa https(SSL)
// Batas maksimal untuk pengecekan mode enroll
int maxCount = 80; // nilai untuk pengecekan mode enroll. makin kecil makin cepat cek enroll

//=========================================== END KONFIG =============================================

// Definisi pin untuk buzzer 3-pin (S/IO, VCC, GND)
#define BUZZER_PIN D2  // Pin signal buzzer
const bool BUZZER_ACTIVE_HIGH = true; // set false jika modul buzzer aktif-LOW

// Serial software untuk komunikasi dengan fingerprint sensor pada pin 13 (RX) dan 12 (TX)
SoftwareSerial mySerial(13, 12);

// Variabel global untuk tracking count, status cek, ID fingerprint, dan objek fingerprint
int count = 1;
boolean cek = false;
int fingerprintID = 0;
Adafruit_Fingerprint finger = Adafruit_Fingerprint(&mySerial);
RTC_DS3231 rtc;

// Variabel untuk ID fingerprint, objek HTTP, dan pesan
uint8_t id;
HTTPClient http;
String message;

// Fungsi setup: Inisialisasi serial, LCD, buzzer, dan fingerprint sensor
void setup()
{
  // Mulai serial komunikasi pada baud rate 9600
  Serial.begin(9600);
  // Inisialisasi Wire untuk I2C pada pin D3 (SDA) dan D4 (SCL)
  Wire.begin(D3, D4); //PIN (SDA, SCL)
  // Inisialisasi LCD
  lcd.begin();
  // Tampilkan pesan awal pada LCD
  lcd.setCursor(6, 0);
  lcd.print("FPM");
  lcd.setCursor(4, 1);
  lcd.print("PRESENSI");
  // Tunggu serial siap
  while (!Serial);
  delay(100);
  // Pesan debug untuk enrollment fingerprint
  Serial.println("\n\nAdafruit Fingerprint sensor enrollment");

  // Inisialisasi buzzer sebagai output dan set LOW untuk memastikan tidak berbunyi
  pinMode(BUZZER_PIN, OUTPUT);
  digitalWrite(BUZZER_PIN, BUZZER_ACTIVE_HIGH ? LOW : HIGH);  // Pastikan buzzer mati saat startup

  if (!rtc.begin()) {
    lcd.clear();
    lcd.print("RTC ERROR");
    beepError();
    while (1) {
      delay(1);
    }
  }

  // Mulai fingerprint sensor pada baud rate 57600
  finger.begin(57600);

  // Verifikasi password fingerprint sensor
  if (finger.verifyPassword()) {
    // Jika berhasil, lanjut
  } else {
    // Jika gagal, tampilkan error pada LCD dan beep error
    lcd.clear();
    lcd.print("FPM ERROR");
    //beepError();  // Beep error jika fingerprint gagal
    // Loop tak terbatas
    while (1) {
      delay(1);
    }
  }
  // Koneksi ke WiFi
  connectWifi();
  syncRtcFromNtp();
}

// Buzzer aktif 3-pin: gunakan HIGH/LOW sederhana
void beepSuccess() {
  digitalWrite(BUZZER_PIN, BUZZER_ACTIVE_HIGH ? HIGH : LOW);
  delay(200);
  digitalWrite(BUZZER_PIN, BUZZER_ACTIVE_HIGH ? LOW : HIGH);
  delay(100);
}

void beepError() {
  digitalWrite(BUZZER_PIN, BUZZER_ACTIVE_HIGH ? HIGH : LOW);
  delay(500);
  digitalWrite(BUZZER_PIN, BUZZER_ACTIVE_HIGH ? LOW : HIGH);
  delay(150);
}

// Fungsi untuk membaca angka dari serial
uint8_t readnumber(void) {
  uint8_t num = 0;
  // Tunggu input serial
  while (num == 0) {
    while (! Serial.available());
    num = Serial.parseInt();
  }
  return num;
}

// Fungsi loop utama: cek WiFi, tampilkan instruksi, dan proses fingerprint atau enroll
void loop()
{
  // Jika WiFi terhubung
  if (WiFi.status() == WL_CONNECTED) {
    // Tampilkan instruksi pada LCD
    DateTime now = rtc.now();
    char timeBuff[9];
    snprintf(timeBuff, sizeof(timeBuff), "%02d:%02d:%02d", now.hour(), now.minute(), now.second());
    lcd.setCursor(0, 0);
    lcd.print("        "); // bersihkan baris waktu supaya tidak ada sisa karakter
    lcd.setCursor(0, 0);
    lcd.print(timeBuff);
    lcd.setCursor(0, 1);
    lcd.print("TEMPELKAN JARI ");
    // Increment count
    count += 1;
    // Jika count dalam batas dan belum cek, dapatkan ID fingerprint
    if (count <= maxCount && cek == false) {
      fingerprintID = getFingerprintIDez();
    } else {
      // Akhiri HTTP dan set cek true
      http.end();
      delay(50);
      cek = true;
    }

    // Jika cek true, lakukan request HTTP untuk kontroler
    if (cek) {
      http.begin(url_server + "/fpm_absen/konfig/prosesdaftar/kontroler.php");
      http.setTimeout(15000);
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");
      int httpCode = http.POST("key=x124sr3sQQ2d");
      delay(100);
      if (httpCode > 0) {
        String payload = http.getString();
        Serial.println(payload);
        // Proses JSON response
        char json[500];
        payload.replace(" ", "");
        payload.replace("\n", "");
        payload.trim();
        payload.toCharArray(json, 500);
        StaticJsonDocument<200> doc;
        deserializeJson(doc, json);
        int response = doc["status"];
        int id_daftar = doc["id"];
        if (response == 1) {
          Serial.println("Tidak ada ID");
          //beepError();  // Beep jika tidak ada ID
        } else if (response == 0) {
          id = id_daftar;
          if (id == 0) {
            return;
          } else {
            http.end();
            daftar();  // Panggil fungsi daftar
          }
        }
      }
      // Reset cek dan count
      cek = false;
      count = 0;
    }
  } else {
    // Jika WiFi tidak terhubung, koneksi ulang
    connectWifi();
    syncRtcFromNtp();
  }
}

// Fungsi untuk koneksi WiFi
void connectWifi() {
  // Tampilkan status koneksi pada LCD
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("STATUS KONEKSI :");
  // Mulai koneksi WiFi
  WiFi.begin(ssid, password);
  // Tunggu hingga terhubung
  while (WiFi.status() != WL_CONNECTED) {
    lcd.setCursor(0, 1);
    lcd.print("Connecting...");
    delay(500);
    lcd.setCursor(0, 1);
    lcd.print("                ");
  }
  // Tampilkan connected dan IP
  lcd.clear();
  lcd.setCursor(4, 0);
  lcd.print("CONNECTED");
  lcd.setCursor(0, 1);
  lcd.print(WiFi.localIP());
  beepSuccess();  // Beep saat WiFi connected
  delay(4000);
  lcd.clear();
}

void syncRtcFromNtp() {
  configTime(7 * 3600, 0, "pool.ntp.org", "time.nist.gov"); // offset WIB
  time_t now = time(nullptr);
  int retry = 0;
  while (now < 1700000000 && retry < 20) {
    delay(500);
    now = time(nullptr);
    retry++;
  }
  if (now >= 1700000000) {
    struct tm *timeinfo = localtime(&now);
    rtc.adjust(DateTime(timeinfo->tm_year + 1900, timeinfo->tm_mon + 1, timeinfo->tm_mday,
                        timeinfo->tm_hour, timeinfo->tm_min, timeinfo->tm_sec));
    beepSuccess();
  } else {
    rtc.adjust(DateTime(F(__DATE__), F(__TIME__)));
    beepError();
  }
}

// Fungsi untuk proses pendaftaran fingerprint
void daftar() {
  // Tampilkan ID baru pada LCD
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("ID BARU : ");
  lcd.print(id);
  // Tunggu hingga enrollment berhasil
  while (!  getFingerprintEnroll() );
}

// Fungsi untuk enrollment fingerprint
uint8_t getFingerprintEnroll() {
  int p = -1;
  Serial.print("Waiting for valid finger to enroll as #"); Serial.println(id);
  // Tunggu gambar fingerprint
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
    switch (p) {
      case FINGERPRINT_OK:
        Serial.println("Image taken");
        break;
      case FINGERPRINT_NOFINGER:
        lcd.setCursor(0, 1);
        lcd.print("SCAN SIDIK JARI");
        Serial.println(".");
        break;
      case FINGERPRINT_PACKETRECIEVEERR:
        Serial.println("Communication error");
        beepError();
        break;
      case FINGERPRINT_IMAGEFAIL:
        Serial.println("Imaging error");
        beepError();
        break;
      default:
        Serial.println("Unknown error");
       // beepError();
        break;
    }
  }

  // Konversi gambar ke template 1
  p = finger.image2Tz(1);
  switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image converted");
      break;
    case FINGERPRINT_IMAGEMESS:
      Serial.println("Image too messy");
      //beepError();
      return p;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      //beepError();
      return p;
    case FINGERPRINT_FEATUREFAIL:
      Serial.println("Could not find fingerprint features");
      //beepError();
      return p;
    case FINGERPRINT_INVALIDIMAGE:
      Serial.println("Could not find fingerprint features");
      //beepError();
      return p;
    default:
      Serial.println("Unknown error");
      //beepError();
      return p;
  }

  // Instruksi angkat jari
  lcd.setCursor(0, 1);
  lcd.print("ANGKAT JARI     ");
  delay(2000);
  p = 0;
  // Tunggu jari diangkat
  while (p != FINGERPRINT_NOFINGER) {
    p = finger.getImage();
  }
  Serial.print("ID "); Serial.println(id);
  p = -1;
  // Tunggu scan ulang
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
    switch (p) {
      case FINGERPRINT_OK:
        lcd.setCursor(0, 1);
        lcd.print("TEMPLATE DIBACA");
        Serial.println("Image taken");
        break;
      case FINGERPRINT_NOFINGER:
        Serial.print(".");
        lcd.setCursor(0, 1);
        lcd.print("ULANGI SCAN JARI");
        break;
      case FINGERPRINT_PACKETRECIEVEERR:
        Serial.println("Komunikasi Error");
        beepError();
        break;
      case FINGERPRINT_IMAGEFAIL:
        Serial.println("Template Error");
        beepError();
        break;
      default:
        Serial.println("Unknown error");
      beepError();
        break;
    }
  }

  // Konversi gambar ke template 2
  p = finger.image2Tz(2);
  switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image converted");
      break;
    case FINGERPRINT_IMAGEMESS:
      Serial.println("Image too messy");
      beepError();
      return p;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      beepError();
      return p;
    case FINGERPRINT_FEATUREFAIL:
      Serial.println("Could not find fingerprint features");
      beepError();
      return p;
    case FINGERPRINT_INVALIDIMAGE:
      Serial.println("Could not find fingerprint features");
      beepError();
      return p;
    default:
      Serial.println("Unknown error");
      beepError();
      return p;
  }

  // Buat model fingerprint
  Serial.print("Creating model for #");  Serial.println(id);
  p = finger.createModel();
  if (p == FINGERPRINT_OK) {
    lcd.setCursor(0, 1);
    lcd.print("JARI SESUAI     ");
    Serial.println("Prints matched!");
    beepSuccess();
  } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    Serial.println("Komunikasi Error");
    beepError();
    return p;
  } else if (p == FINGERPRINT_ENROLLMISMATCH) {
    Serial.println("Jari Tidak Cocok");
    lcd.setCursor(0, 1);
    lcd.print("JARI TIDAK COCOK");
    beepError();
    message = "NotFound";
    return p;
  } else {
    Serial.println("Unknown error");
    beepError();
    return p;
  }

  // Simpan model
  Serial.print("ID "); Serial.println(id);
  p = finger.storeModel(id);
  if (p == FINGERPRINT_OK) {
    lcd.setCursor(0, 1);
    lcd.print("MENYIMPAN DATA..");
    Serial.println("Berhasil Menyimpan ID");
    delay(1000);
    beepSuccess();
    message = "Sukses";
  } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    message = "Komunikasi Error";
    Serial.println("Kumunikasi Error");
    beepError();
    return p;
  } else if (p == FINGERPRINT_BADLOCATION) {
    message = "Gagal Menyimpan";
    Serial.println("Gagal Menyimpan");
    beepError();
    return p;
  } else if (p == FINGERPRINT_FLASHERR) {
    message = "Flash Gagal";
    Serial.println("");
    beepError();
    return p;
  } else {
    Serial.println("Unknown error");
    beepError();
    return p;
  }

  // Kirim data ke server
  Serial.println("AKSES URL");
  http.begin(url_server + "/fpm_absen/konfig/prosesdaftar/daftar.php");
  http.setTimeout(15000);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  int httpCode = http.POST("id=kontroler&parameter=" + message);
  delay(100);
  if (httpCode > 0) {
    String payload = http.getString();
    lcd.setCursor(0, 1);
    lcd.print("SUKSES MENYIMPAN");
    beepSuccess();
    Serial.println(payload);
  } else {
    lcd.clear();
    lcd.print("ERROR : ");
    lcd.print(httpCode);
    Serial.print("HTTP error (daftar) code: ");
    Serial.println(httpCode);
    Serial.print("HTTP error string: ");
    Serial.println(http.errorToString(httpCode));
    beepError();
  }
  http.end();
  delay(1000);
  lcd.clear();
}

// Fungsi untuk mendapatkan ID fingerprint dan melakukan absen
int getFingerprintIDez() {
  // Ambil gambar
  uint8_t p = finger.getImage();
  if (p != FINGERPRINT_OK)  return -1;

  // Konversi ke template
  p = finger.image2Tz();
  if (p != FINGERPRINT_OK)  return -1;

  // Cari fingerprint
  p = finger.fingerFastSearch();
  if (p != FINGERPRINT_OK)  return -1;

  // Tampilkan hasil
  Serial.print("Found ID #");
  Serial.print(finger.fingerID);
  Serial.print(" with confidence of ");
  Serial.println(finger.confidence);
  beepSuccess();  // Beep saat fingerprint dikenali
  absen();  // Panggil fungsi absen
  return finger.fingerID;
}

// Fungsi untuk proses absensi
void absen() {
  http.end();
  // Tampilkan ID dan status pada LCD
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("ID : ");
  lcd.print(String(finger.fingerID));
  lcd.setCursor(0, 1);
  lcd.print("PROSES PRESENSI");
  delay(300);
  lcd.setCursor(0, 1);
  lcd.print("ANGKAT JARI     ");
  // Kirim request absen ke server
  http.begin(url_server + "/fpm_absen/konfig/absen.php");
  http.setTimeout(15000);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  delay(100);
  int httpCode = http.POST("id=" + String(finger.fingerID));
  delay(300);
  if (httpCode > 0) {
    String payload = http.getString();
    lcd.setCursor(0, 1);
    Serial.print("Response = ");
    lcd.print(payload);
    lcd.print("  ");
    beepSuccess();  // Beep saat presensi berhasil
    Serial.println(payload);
  } else {
    // Tampilkan error
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("COBA LAGI....!");
    lcd.setCursor(0, 1);
    lcd.print("Error : ");
    lcd.print(httpCode);
    Serial.print("HTTP error (absen) code: ");
    Serial.println(httpCode);
    Serial.print("HTTP error string: ");
    Serial.println(http.errorToString(httpCode));
    beepError();  // Beep saat error
  }
  http.end();
  count = 0;
  delay(1000);
  lcd.clear();
}
