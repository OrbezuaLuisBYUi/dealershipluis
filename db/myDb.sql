CREATE TABLE "public"."warranties" (
  war_key_inside SERIAL NOT NULL PRIMARY KEY,
  war_months int4 NOT NULL
) WITH (OIDS=FALSE);

CREATE TABLE "public"."cars" (
  car_key_inside SERIAL NOT NULL PRIMARY KEY,
  car_brand varchar(100) NOT NULL,
  car_model varchar(100) NOT NULL,
  car_year int4 NOT NULL,
  war_key_inside int4 NOT NULL REFERENCES public.warranty(war_key_inside),
  car_price float NOT NULL,
  car_zip_code varchar(50) NOT NULL,
  car_img varchar(100) NOT NULL
) WITH (OIDS=FALSE);

ALTER TABLE public.cars ADD COLUMN use_key_inside int4 NULL REFERENCES public.users(use_key_inside);
update public.cars set car_brand = 'Toyota',car_model = '1200',car_year = 3000,war_key_inside = 2,car_price = 50000,use_key_inside = 62 where car_key_inside = 8

CREATE TABLE "public"."users" (
  use_key_inside SERIAL NOT NULL PRIMARY KEY,
  use_username varchar(20) NOT NULL,
  use_password varchar(20) NOT NULL,
  use_name varchar(100) NOT NULL,
  use_lastname varchar(100) NOT NULL,
  use_phone varchar(25) NOT NULL,
  use_email varchar(150) NOT NULL,
  use_address varchar(50) NOT NULL,
  use_profile int4 NOT NULL DEFAULT 2
) WITH (OIDS=FALSE);

ALTER TABLE public.users ALTER COLUMN use_password TYPE varchar(200);
select use_key_inside,use_username,use_password,use_name,use_lastname,use_phone,use_email,use_address,CASE use_profile WHEN 1 THEN 'Administrator' ELSE 'Client' END use_profile from public.users

CREATE TABLE "public"."loans" (
  lon_key_inside SERIAL NOT NULL PRIMARY KEY,
  lon_months int4 NOT NULL
) WITH (OIDS=FALSE);


CREATE TABLE "public"."users_cars" (
  usc_key_inside SERIAL NOT NULL PRIMARY KEY,
  use_key_inside int4 NOT NULL REFERENCES public.users(use_key_inside),
  car_key_inside int4 NOT NULL REFERENCES public.cars(car_key_inside),
  usc_sw_email int4 NOT NULL,
  usc_payment_method varchar(50) NOT NULL,
  usc_loan float NOT NULL,
  usc_cash float NOT NULL,
  lon_key_inside int4 NOT NULL REFERENCES public.loan(lon_key_inside)
) WITH (OIDS=FALSE);

ALTER TABLE public.users_cars RENAME COLUMN usc_sw_loan TO usc_loan;
ALTER TABLE public.users_cars ALTER COLUMN usc_loan TYPE float;
ALTER TABLE public.users_cars ALTER COLUMN usc_loan SET DEFAULT 0;
ALTER TABLE public.users_cars ALTER COLUMN usc_cash SET DEFAULT 0;
ALTER TABLE public.users_cars ALTER COLUMN lon_key_inside DROP NOT NULL;

select use_name,use_lastname,use_username,use_password,use_profile from users where UPPER(use_username) = UPPER('luis') and UPPER(use_password) = UPPER('luis123')