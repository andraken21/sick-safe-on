-- ================================
-- MIGRATION SCRIPT: Numeric ID → String Format
-- Database: sick-safe-on
-- ================================

SET FOREIGN_KEY_CHECKS = 0;

-- Update Users
ALTER TABLE users MODIFY COLUMN id_user VARCHAR(255) NOT NULL UNIQUE;
UPDATE users SET id_user = CONCAT('usr', LPAD(CAST(id_user AS UNSIGNED), 3, '0')) ORDER BY CAST(id_user AS UNSIGNED) DESC;

-- Update Medicines (Obat)
ALTER TABLE medicines MODIFY COLUMN id_obat VARCHAR(255) NOT NULL UNIQUE;
UPDATE medicines SET id_obat = CONCAT('obt', LPAD(CAST(id_obat AS UNSIGNED), 3, '0')) ORDER BY CAST(id_obat AS UNSIGNED) DESC;

-- Update Apoteker
ALTER TABLE apoteker MODIFY COLUMN id_apoteker VARCHAR(255) NOT NULL UNIQUE;
ALTER TABLE apoteker MODIFY COLUMN id_user VARCHAR(255) NOT NULL;
UPDATE apoteker SET id_apoteker = CONCAT('apt', LPAD(CAST(id_apoteker AS UNSIGNED), 3, '0')) ORDER BY CAST(id_apoteker AS UNSIGNED) DESC;

-- Update Dokter
ALTER TABLE dokter MODIFY COLUMN id_dokter VARCHAR(255) NOT NULL UNIQUE;
ALTER TABLE dokter MODIFY COLUMN id_user VARCHAR(255) NOT NULL;
UPDATE dokter SET id_dokter = CONCAT('dr', LPAD(CAST(id_dokter AS UNSIGNED), 3, '0')) ORDER BY CAST(id_dokter AS UNSIGNED) DESC;

-- Update Pasien
ALTER TABLE pasien MODIFY COLUMN id_pasien VARCHAR(255) NOT NULL UNIQUE;
ALTER TABLE pasien MODIFY COLUMN id_user VARCHAR(255) NOT NULL;
UPDATE pasien SET id_pasien = CONCAT('pst', LPAD(CAST(id_pasien AS UNSIGNED), 3, '0')) ORDER BY CAST(id_pasien AS UNSIGNED) DESC;

-- Update Prescriptions
ALTER TABLE prescriptions MODIFY COLUMN id_resep VARCHAR(255) NOT NULL UNIQUE;
ALTER TABLE prescriptions MODIFY COLUMN id_dokter VARCHAR(255) NOT NULL;
ALTER TABLE prescriptions MODIFY COLUMN id_apoteker VARCHAR(255) NULL;
ALTER TABLE prescriptions MODIFY COLUMN id_pasien VARCHAR(255) NOT NULL;
UPDATE prescriptions SET id_resep = CONCAT('rsp', LPAD(CAST(id_resep AS UNSIGNED), 3, '0')) ORDER BY CAST(id_resep AS UNSIGNED) DESC;

-- Update Prescription Details
ALTER TABLE prescription_details MODIFY COLUMN id_detail VARCHAR(255) NOT NULL UNIQUE;
ALTER TABLE prescription_details MODIFY COLUMN id_resep VARCHAR(255) NOT NULL;
ALTER TABLE prescription_details MODIFY COLUMN id_obat VARCHAR(255) NOT NULL;
UPDATE prescription_details SET id_detail = CONCAT('dtl', LPAD(CAST(id_detail AS UNSIGNED), 3, '0')) ORDER BY CAST(id_detail AS UNSIGNED) DESC;

-- Update Transactions
ALTER TABLE transactions MODIFY COLUMN id_pembayaran VARCHAR(255) NOT NULL UNIQUE;
ALTER TABLE transactions MODIFY COLUMN id_resep VARCHAR(255) NOT NULL;
UPDATE transactions SET id_pembayaran = CONCAT('pmb', LPAD(CAST(id_pembayaran AS UNSIGNED), 3, '0')) ORDER BY CAST(id_pembayaran AS UNSIGNED) DESC;

SET FOREIGN_KEY_CHECKS = 1;

-- ================================
-- VERIFICATION
-- ================================
SELECT 'Migration Complete!' as status;
SELECT COUNT(*) as total_usr FROM users WHERE id_user LIKE 'usr%';
SELECT COUNT(*) as total_obt FROM medicines WHERE id_obat LIKE 'obt%';
SELECT * FROM users LIMIT 1;
SELECT * FROM medicines LIMIT 1;