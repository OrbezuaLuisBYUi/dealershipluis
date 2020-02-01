CREATE TABLE "public"."warranty" (
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


CREATE TABLE "public"."users" (
  use_key_inside SERIAL NOT NULL PRIMARY KEY,
  use_name varchar(100) NOT NULL,
  use_lastname varchar(100) NOT NULL,
  use_phone varchar(25) NOT NULL,
  use_email varchar(150) NOT NULL,
  use_address varchar(50) NOT NULL,
  use_profile int4 NOT NULL DEFAULT 2
) WITH (OIDS=FALSE);


CREATE TABLE "public"."loan" (
  lon_key_inside SERIAL NOT NULL PRIMARY KEY,
  lon_months int4 NOT NULL
) WITH (OIDS=FALSE);


CREATE TABLE "public"."users_cars" (
  usc_key_inside SERIAL NOT NULL PRIMARY KEY,
  use_key_inside int4 NOT NULL REFERENCES public.users(use_key_inside),
  car_key_inside int4 NOT NULL REFERENCES public.cars(car_key_inside),
  usc_sw_email int4 NOT NULL,
  usc_payment_method varchar(50) NOT NULL,
  usc_sw_loan int4 NOT NULL,
  usc_cash float NOT NULL,
  lon_key_inside int4 NOT NULL REFERENCES public.loan(lon_key_inside)
) WITH (OIDS=FALSE);