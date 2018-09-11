--
-- File generated with SQLiteStudio v3.1.1 on Fri Aug 31 21:31:35 2018
--
-- Text encoding used: UTF-8
--
PRAGMA foreign_keys = off;
BEGIN TRANSACTION;

-- Table: client
DROP TABLE IF EXISTS client;

CREATE TABLE client (
    client_id      INTEGER       NOT NULL
                                 PRIMARY KEY AUTOINCREMENT,
    client_name    VARCHAR (100) NOT NULL,
    client_phone   VARCHAR (30)  NOT NULL,
    client_email   VARCHAR (100) NOT NULL,
    client_address VARCHAR (500) NOT NULL,
    client_orc     VARCHAR (50),
    client_cui     VARCHAR (50),
    client_bank    VARCHAR (50),
    client_account VARCHAR (50) 
);

INSERT INTO client (client_id, client_name, client_phone, client_email, client_address, client_orc, client_cui, client_bank, client_account) VALUES (1, 'SC NEXTGEN NETWORKS SRL', '+40 (364) 417.999', 'info@nextgen-networks.ro', 'Buna Ziua 34-36 et. 2, 400193 Cluj-Napoca, jud. Cluj, Romania', 'J12/3195/2008', 'RO 24252765', 'Banca Transilvania', 'RO46 BTRL 0130 1202 L418 99XX');
INSERT INTO client (client_id, client_name, client_phone, client_email, client_address, client_orc, client_cui, client_bank, client_account) VALUES (2, 'SC GAMA SOFTWARE SRL', '+40 (364) 417.999', '', 'Buna Ziua 34-36 et. 2, 400193 Cluj-Napoca, jud. Cluj, Romania', 'J12/3052/2013', 'RO 32339715', 'Banca Transilvania', 'RO37BTRLRONCRT0230861901');
INSERT INTO client (client_id, client_name, client_phone, client_email, client_address, client_orc, client_cui, client_bank, client_account) VALUES (3, 'SC International Brand Stores SRL', '0730 574061', '', 'Str. Trifoiului, F.N., Cluj-Napoca, Jud. Cluj.', 'J12/2105/2010', '27795839', 'Banca Transilvania', 'RO66BTRL01301202319791XX');
INSERT INTO client (client_id, client_name, client_phone, client_email, client_address, client_orc, client_cui, client_bank, client_account) VALUES (4, 'SC YYZ Partners SRL', '', '', 'Sibiu, Str. Marasesti, nr. 4, Jud. Sibiu', 'J32/549/18.06.2014', '29064550 RO', 'Transilvania SA', 'RO28BTRL01301202H74596XX');
INSERT INTO client (client_id, client_name, client_phone, client_email, client_address, client_orc, client_cui, client_bank, client_account) VALUES (5, 'SC EUROLEX AUDIT SRL', '0744558273', 'office@eurolexaudit.ro', 'Cluj-Napoca, Str. G-ral Traian Mosoiu, nr. 50, ap.24, jud. Cluj', 'J12/155/2004', '16049361', NULL, NULL);
INSERT INTO client (client_id, client_name, client_phone, client_email, client_address, client_orc, client_cui, client_bank, client_account) VALUES (6, 'SC SABIN EVENTS SRL', '', '', 'Str. Memorandumului nr.12, ap.16, 400114 Cluj-Napoca', 'J12/3340/2015', '3519422', 'Banca Transilvania Cluj-Napoca', 'RO75BRTLRONCRT0325676001');
INSERT INTO client (client_id, client_name, client_phone, client_email, client_address, client_orc, client_cui, client_bank, client_account) VALUES (7, 'SC NCS Inspire SRL', '0730083355', '', 'Cluj-Napoca, str. Gheorghe Lazar nr. 22', 'J12/391/2014', 'RO 32766708', 'ING Bank Cluj', 'RO30 INGB 0000 9999 0407 5729');
INSERT INTO client (client_id, client_name, client_phone, client_email, client_address, client_orc, client_cui, client_bank, client_account) VALUES (8, 'SC Vital Team SRL', '0728730374', 'info@vitalteam.ro', 'Cluj-Napoca, Str. Prof. Dr. Gheorghe Marinescu Nr. 16', 'J12/1025/2016', '35778944', '', '');

-- Table: contract
DROP TABLE IF EXISTS contract;

CREATE TABLE contract (
    contract_id   INTEGER      NOT NULL
                               PRIMARY KEY AUTOINCREMENT,
    contract_no   VARCHAR (10) NOT NULL,
    status        VARCHAR (10) NOT NULL,
    client_id     INTEGER      NOT NULL
                               REFERENCES client (client_id) DEFERRABLE INITIALLY DEFERRED,
    provider_id   INTEGER      NOT NULL
                               REFERENCES provider (provider_id) DEFERRABLE INITIALLY DEFERRED,
    contract_date DATE         NOT NULL
);

INSERT INTO contract (contract_id, contract_no, status, client_id, provider_id, contract_date) VALUES (1, '0', 'disabled', 1, 1, '');
INSERT INTO contract (contract_id, contract_no, status, client_id, provider_id, contract_date) VALUES (2, '0', 'disabled', 2, 1, '');
INSERT INTO contract (contract_id, contract_no, status, client_id, provider_id, contract_date) VALUES (3, '1', 'enabled', 3, 1, '2014-04-09');
INSERT INTO contract (contract_id, contract_no, status, client_id, provider_id, contract_date) VALUES (4, '31', 'enabled', 4, 1, '2016-01-01');
INSERT INTO contract (contract_id, contract_no, status, client_id, provider_id, contract_date) VALUES (5, '30', 'enabled', 5, 1, '2016-01-19');
INSERT INTO contract (contract_id, contract_no, status, client_id, provider_id, contract_date) VALUES (6, '32', 'enabled', 6, 1, '2016-02-19');
INSERT INTO contract (contract_id, contract_no, status, client_id, provider_id, contract_date) VALUES (7, '10', 'enabled', 7, 1, '2017-05-26');
INSERT INTO contract (contract_id, contract_no, status, client_id, provider_id, contract_date) VALUES (8, '11', 'enabled', 8, 1, '2017-06-28');

-- Table: invoice
DROP TABLE IF EXISTS invoice;

CREATE TABLE invoice (
    invoice_id   INTEGER      NOT NULL
                              PRIMARY KEY AUTOINCREMENT,
    invoice_no   VARCHAR (10) NOT NULL,
    contract_id  INTEGER      NOT NULL
                              REFERENCES contract (contract_id) DEFERRABLE INITIALLY DEFERRED,
    invoice_date VARCHAR (15) NOT NULL
);

INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (1, '001', 1, '2013-06-28');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (2, '002', 1, '2013-07-31');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (3, '003', 1, '2013-08-30');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (4, '004', 1, '2013-09-30');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (5, '005', 1, '2013-10-31');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (6, '006', 1, '2013-11-29');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (7, '007', 1, '2013-12-31');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (8, '008', 2, '2014-01-31');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (9, '009', 2, '2014-02-28');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (10, '10', 2, '2014-03-31');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (11, '11', 3, '2014-04-09');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (12, '12', 2, '2014-04-30');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (13, '13', 2, '2014-05-30');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (14, '15', 4, '2014-08-29');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (15, '16', 4, '2014-09-30');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (16, '17', 4, '2014-10-31');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (17, '18', 4, '2014-11-28');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (18, '19', 4, '2014-12-30');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (19, '20', 4, '2015-01-30');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (20, '21', 4, '2015-02-27');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (21, '14', 4, '2014-07-07');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (22, '24', 4, '2015-05-29');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (23, '25', 4, '2015-06-30');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (24, '26', 4, '2015-07-31');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (25, '27', 4, '2015-08-31');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (26, '28', 4, '2015-09-30');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (27, '29', 4, '2015-10-30');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (28, '30', 4, '2015-11-27');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (29, '31', 4, '2015-12-30');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (30, '32', 5, '2016-01-19');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (31, '35', 4, '2016-02-29');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (32, '34', 6, '2016-02-22');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (33, '36', 4, '2016-03-31');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (34, '37', 4, '2016-04-29');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (35, '38', 4, '2016-05-11');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (36, '39', 4, '2016-05-31');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (37, '40', 4, '2016-06-30');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (38, '41', 4, '2016-07-12');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (39, '42', 4, '2016-07-29');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (40, '43', 4, '2016-08-16');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (41, '44', 4, '2016-08-31');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (42, '45', 4, '2016-09-07');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (43, '46', 4, '2016-09-30');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (44, '48', 4, '2016-10-31');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (45, '49', 4, '2016-11-29');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (46, '51', 4, '2016-12-30');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (47, '53', 4, '2017-01-31');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (48, '54', 4, '2017-02-28');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (49, '55', 4, '2017-03-31');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (50, '56', 4, '2017-04-28');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (51, '57', 7, '2017-05-26');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (52, '58', 4, '2017-05-30');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (53, '59', 8, '2017-06-28');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (54, '60', 4, '2017-06-28');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (55, '61', 4, '2017-07-31');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (56, '62', 4, '2017-08-31');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (57, '63', 4, '2017-09-29');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (58, '64', 4, '2017-10-27');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (59, '65', 4, '2017-11-24');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (60, '66', 4, '2017-12-22');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (61, '67', 4, '2018-01-31');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (62, '68', 4, '2018-02-28');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (63, '69', 4, '30-Mar-2018');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (64, '70', 4, '04-Mai-2018');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (65, '71', 4, '30-Mai-2018');
INSERT INTO invoice (invoice_id, invoice_no, contract_id, invoice_date) VALUES (66, '72', 4, '05-Iul-2018');

-- Table: invoice_line
DROP TABLE IF EXISTS invoice_line;

CREATE TABLE invoice_line (
    invoice_line_id INTEGER NOT NULL
                            PRIMARY KEY AUTOINCREMENT,
    qty             INTEGER NOT NULL,
    invoice_id      INTEGER NOT NULL
                            REFERENCES invoice (invoice_id) DEFERRABLE INITIALLY DEFERRED,
    service_id      INTEGER NOT NULL
                            REFERENCES service (service_id) DEFERRABLE INITIALLY DEFERRED,
    price           REAL    NOT NULL
);

INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (1, 1, 1, 1, 5550);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (2, 1, 2, 1, 6700);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (3, 1, 3, 1, 8220);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (4, 1, 4, 1, 6700);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (5, 1, 5, 1, 6700);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (6, 1, 6, 1, 8220);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (7, 1, 7, 1, 6700);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (8, 1, 8, 1, 6700);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (9, 1, 9, 1, 8434);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (10, 1, 10, 1, 6700);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (12, 1, 12, 1, 6700);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (13, 1, 13, 1, 8400);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (14, 1, 14, 1, 12435);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (15, 1, 15, 1, 6030);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (16, 1, 16, 1, 6030);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (17, 1, 17, 1, 7085);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (18, 1, 18, 1, 6030);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (19, 1, 19, 1, 6036);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (20, 1, 20, 1, 7000);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (21, 1, 21, 1, 6030);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (22, 1, 22, 1, 7021);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (23, 1, 23, 1, 6008);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (24, 1, 24, 1, 5958);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (25, 1, 25, 1, 6930);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (26, 1, 26, 1, 5945);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (27, 1, 27, 1, 5953);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (28, 1, 28, 1, 6925);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (29, 1, 29, 1, 5991);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (30, 1, 30, 1, 700);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (31, 1, 31, 1, 10790);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (33, 1, 33, 1, 12720);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (34, 1, 34, 1, 5992);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (35, 1, 35, 1, 1500);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (36, 1, 36, 1, 18300);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (37, 1, 37, 1, 16800);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (38, 1, 38, 1, 6000);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (39, 1, 39, 1, 12275);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (40, 1, 40, 1, 12000);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (41, 1, 41, 1, 8686);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (42, 1, 42, 1, 10000);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (43, 1, 43, 1, 16760);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (44, 1, 44, 1, 6334);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (45, 1, 45, 1, 14180);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (46, 1, 46, 1, 16613);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (47, 1, 47, 1, 8020);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (48, 1, 48, 1, 19226);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (49, 1, 49, 1, 17222);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (52, 1, 52, 1, 8930);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (54, 1, 54, 1, 6910);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (55, 1, 55, 1, 6898);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (56, 1, 56, 1, 12080);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (57, 1, 57, 1, 6912);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (58, 1, 58, 1, 6919);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (59, 1, 59, 1, 8928);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (60, 1, 60, 1, 6903);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (61, 1, 61, 1, 6900);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (62, 1, 62, 1, 8900);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (63, 1, 51, 1, 1800);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (64, 1, 11, 1, 1800);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (65, 1, 53, 1, 2200);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (67, 1, 32, 1, 900);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (68, 1, 50, 1, 17210);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (69, 1, 63, 1, 6870);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (70, 1, 64, 1, 6860);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (71, 1, 65, 1, 13750);
INSERT INTO invoice_line (invoice_line_id, qty, invoice_id, service_id, price) VALUES (72, 1, 66, 1, 6870);

-- Table: provider
DROP TABLE IF EXISTS provider;

CREATE TABLE provider (
    provider_id      INTEGER       NOT NULL
                                   PRIMARY KEY AUTOINCREMENT,
    provider_name    VARCHAR (100) NOT NULL,
    provider_phone   VARCHAR (30)  NOT NULL,
    provider_email   VARCHAR (100) NOT NULL,
    provider_address VARCHAR (500) NOT NULL,
    provider_orc     VARCHAR (50),
    provider_cui     VARCHAR (50),
    provider_bank    VARCHAR (50),
    provider_account VARCHAR (50) 
);

INSERT INTO provider (provider_id, provider_name, provider_phone, provider_email, provider_address, provider_orc, provider_cui, provider_bank, provider_account) VALUES (1, 'Boara Remus Florian PFA', '0755484009', 'remus.boara@gmail.com', 'Com. Floresti, Str. Sub Cetate 140, Ap. 9, Jud. Cluj', 'F12/1364/2013', '31866008', 'ING BANK', 'RO87INGB0000999903744515');

-- Table: receipt
DROP TABLE IF EXISTS receipt;

CREATE TABLE receipt (
    receipt_id         INTEGER       NOT NULL
                                     PRIMARY KEY AUTOINCREMENT,
    receipt_no         VARCHAR (10)  NOT NULL,
    receipt_date       VARCHAR (15)  NOT NULL,
    receipt_amount     VARCHAR (6)   NOT NULL,
    invoice_id         INTEGER       NOT NULL
                                     REFERENCES invoice (invoice_id) DEFERRABLE INITIALLY DEFERRED,
    receipt_amount_str VARCHAR (255) NOT NULL
);

INSERT INTO receipt (receipt_id, receipt_no, receipt_date, receipt_amount, invoice_id, receipt_amount_str) VALUES (18, '2', '26-Mai-2017', '1800', 51, 'Una Mie Opt Sute');
INSERT INTO receipt (receipt_id, receipt_no, receipt_date, receipt_amount, invoice_id, receipt_amount_str) VALUES (19, '1', '09-Apr-2014', '1800', 11, 'Una Mie Opt Sute');
INSERT INTO receipt (receipt_id, receipt_no, receipt_date, receipt_amount, invoice_id, receipt_amount_str) VALUES (20, '3', '28-Iun-2017', '2200', 53, 'Doua Mii Doua Sute');
INSERT INTO receipt (receipt_id, receipt_no, receipt_date, receipt_amount, invoice_id, receipt_amount_str) VALUES (21, '2', '22-Feb-2016', '900', 32, 'Servicii website www.k1tracia.ro, Noua sute');
INSERT INTO receipt (receipt_id, receipt_no, receipt_date, receipt_amount, invoice_id, receipt_amount_str) VALUES (23, '', '', '', 63, '');

-- Table: service
DROP TABLE IF EXISTS service;

CREATE TABLE service (
    service_id   INTEGER       NOT NULL
                               PRIMARY KEY AUTOINCREMENT,
    service_name VARCHAR (500) NOT NULL
);

INSERT INTO service (service_id, service_name) VALUES (1, 'Servicii consultanta software');

-- Index: contract_client_id_1f016027
DROP INDEX IF EXISTS contract_client_id_1f016027;

CREATE INDEX contract_client_id_1f016027 ON contract (
    "client_id"
);


-- Index: contract_provider_id_3b9279d1
DROP INDEX IF EXISTS contract_provider_id_3b9279d1;

CREATE INDEX contract_provider_id_3b9279d1 ON contract (
    "provider_id"
);


-- Index: invoice_contract_id_73059137
DROP INDEX IF EXISTS invoice_contract_id_73059137;

CREATE INDEX invoice_contract_id_73059137 ON invoice (
    "contract_id"
);


-- Index: invoice_line_invoice_id_e4d25288
DROP INDEX IF EXISTS invoice_line_invoice_id_e4d25288;

CREATE INDEX invoice_line_invoice_id_e4d25288 ON invoice_line (
    "invoice_id"
);


-- Index: invoice_line_service_id_16573f10
DROP INDEX IF EXISTS invoice_line_service_id_16573f10;

CREATE INDEX invoice_line_service_id_16573f10 ON invoice_line (
    "service_id"
);


-- Index: receipt_invoice_id_e089b96e
DROP INDEX IF EXISTS receipt_invoice_id_e089b96e;

CREATE INDEX receipt_invoice_id_e089b96e ON receipt (
    "invoice_id"
);


-- View: data_vw
DROP VIEW IF EXISTS data_vw;
CREATE VIEW data_vw AS
    SELECT a.rowid AS id,
           a.contract_id,
           a.contract_no,
           a.contract_date,
           b.client_id,
           b.client_name,
           b.client_email,
           b.client_phone,
           (
               SELECT group_concat('#' || inv.invoice_no || '/' || inv.invoice_date || ': <strong>' || (
                                                                                                           SELECT SUM(y.price * y.qty) 
                                                                                                             FROM invoice x,
                                                                                                                  invoice_line y
                                                                                                            WHERE x.invoice_id = y.invoice_id AND 
                                                                                                                  x.invoice_id = inv.invoice_id
                                                                                                       )
||                                 ' Lei</strong>') 
                 FROM invoice inv
                WHERE inv.contract_id = a.contract_id
           )
           AS invoice
      FROM contract a,
           client b
     WHERE a.client_id = b.client_id AND 
           a.status = 'enabled';


COMMIT TRANSACTION;
PRAGMA foreign_keys = on;

