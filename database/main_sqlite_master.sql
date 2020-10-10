INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'migrations', 'migrations', 2, 'CREATE TABLE "migrations" ("id" integer not null primary key autoincrement, "migration" varchar not null, "batch" integer not null)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'sqlite_sequence', 'sqlite_sequence', 3, 'CREATE TABLE sqlite_sequence(name,seq)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'users', 'users', 4, 'CREATE TABLE "users" ("id" integer not null primary key autoincrement, "name" varchar not null, "last_name" varchar not null, "email" varchar not null, "email_verified_at" datetime null, "password" varchar not null, "remember_token" varchar null, "created_at" datetime null, "updated_at" datetime null, "admin" varchar check ("admin" in (''S'', ''N'')) not null default ''N'', "deleted_at" datetime null)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('index', 'users_email_unique', 'users', 5, 'CREATE UNIQUE INDEX "users_email_unique" on "users" ("email")');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'password_resets', 'password_resets', 6, 'CREATE TABLE "password_resets" ("email" varchar not null, "token" varchar not null, "created_at" datetime null)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('index', 'password_resets_email_index', 'password_resets', 7, 'CREATE INDEX "password_resets_email_index" on "password_resets" ("email")');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'failed_jobs', 'failed_jobs', 8, 'CREATE TABLE "failed_jobs" ("id" integer not null primary key autoincrement, "connection" text not null, "queue" text not null, "payload" text not null, "exception" text not null, "failed_at" datetime default CURRENT_TIMESTAMP not null)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'categories', 'categories', 9, 'CREATE TABLE "categories" ("id" integer not null primary key autoincrement, "tipo" varchar not null, "deleted_at" datetime null, "created_at" datetime null, "updated_at" datetime null)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'feedback', 'feedback', 10, 'CREATE TABLE "feedback" ("id" integer not null primary key autoincrement, "tipo" varchar check ("tipo" in (''S'', ''R'')) not null, "descricao" text not null, "prioridade" varchar check ("prioridade" in (''B'', ''A'')) not null default ''B'', "user_id" integer not null, "deleted_at" datetime null, "created_at" datetime null, "updated_at" datetime null)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'measures', 'measures', 11, 'CREATE TABLE "measures" ("id" integer not null primary key autoincrement, "nome" varchar not null, "sigla" varchar null, "deleted_at" datetime null, "created_at" datetime null, "updated_at" datetime null)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('index', 'measures_nome_unique', 'measures', 12, 'CREATE UNIQUE INDEX "measures_nome_unique" on "measures" ("nome")');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'products', 'products', 13, 'CREATE TABLE "products" ("id" integer not null primary key autoincrement, "name" varchar not null, "description" text not null, "brand_id" integer null, "image" varchar not null, "deleted_at" datetime null, "created_at" datetime null, "updated_at" datetime null)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'brands', 'brands', 16, 'CREATE TABLE "brands" ("id" integer not null primary key autoincrement, "name" varchar not null, "deleted_at" datetime null, "created_at" datetime null, "updated_at" datetime null)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('index', 'brands_name_unique', 'brands', 17, 'CREATE UNIQUE INDEX "brands_name_unique" on "brands" ("name")');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'product_requests', 'product_requests', 18, 'CREATE TABLE "product_requests" ("id" integer not null primary key autoincrement, "data" date null, "qtde" integer null, "user_id" integer null, "product_id" integer null, "brand_id" integer null, "category_id" integer null, "measure_id" integer null, "deleted_at" datetime null, "created_at" datetime null, "updated_at" datetime null)');