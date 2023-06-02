
Table "carts" {
  "id" int(11) [pk, not null, increment]
  "idUser" int(11) [default: NULL]
  "idProduct" int(11) [default: NULL]
  "quantity" int(11) [default: NULL]

Indexes {
  idUser [name: "idUser"]
  idProduct [name: "idProduct"]
}
}

Table "failed_jobs" {
  "id" int(11) [pk, not null, increment]
  "uuid" varchar(255) [default: NULL]
  "connection" text [default: NULL]
  "queue" text [default: NULL]
  "payload" longtext [default: NULL]
  "exception" longtext [default: NULL]
  "failed_at" timestamp [not null, default: `current_timestamp()`]

Indexes {
  uuid [unique, name: "uuid"]
}
}

Table "groups" {
  "id" int(11) [pk, not null, increment]
  "name" varchar(255) [default: NULL]
  "deadline1" date [default: NULL]
  "deadline2" date [default: NULL]
  "idGroupLeader" int(11) [default: NULL]
  "approved" tinyint(4) [default: NULL]
  "sendEmail1" tinyint(4) [default: NULL]
  "sendEmail2" tinyint(4) [default: NULL]

Indexes {
  idGroupLeader [name: "idGroupLeader"]
}
}

Table "participations" {
  "id" int(11) [pk, not null, increment]
  "request" tinyint(4) [default: NULL]
  "idUser" int(11) [default: NULL]
  "idGroup" int(11) [default: NULL]

Indexes {
  idUser [name: "idUser"]
  idGroup [name: "idGroup"]
}
}

Table "password_resets" {
  "email" varchar(320) [default: NULL]
  "token" varchar(255) [default: NULL]
  "created_at" timestamp [default: NULL]

Indexes {
  email [name: "password_resets_email_index"]
}
}

Table "personal_access_tokens" {
  "id" int(11) [pk, not null, increment]
  "tokenable_id" int(11) [default: NULL]
  "tokenable_type" varchar(255) [default: NULL]
  "name" varchar(255) [default: NULL]
  "token" varchar(64) [default: NULL]
  "abilities" text [default: NULL]
  "last_used_at" timestamp [default: NULL]
  "created_at" timestamp [not null, default: `current_timestamp()`]
  "updated_at" timestamp [not null, default: `current_timestamp()`]

Indexes {
  token [unique, name: "token"]
}
}

Table "products" {
  "id" int(11) [pk, not null, increment]
  "code" varchar(255) [default: NULL]
  "name" varchar(255) [default: NULL]
  "description" varchar(255) [default: NULL]
  "image" longblob [default: NULL]
  "price" decimal(10,2) [default: NULL]
  "quantityMin" int(11) [default: NULL]
  "multiple" int(11) [default: NULL]
  "idGroup" int(11) [default: NULL]
  "visible" tinyint(4) [default: NULL]

Indexes {
  idGroup [name: "idGroup"]
}
}

Table "users" {
  "id" int(11) [pk, not null, increment]
  "name" varchar(255) [default: NULL]
  "surname" varchar(255) [default: NULL]
  "email" varchar(320) [default: NULL]
  "password" varchar(255) [default: NULL]
  "email_verified_at" timestamp [default: NULL]
  "remember_token" varchar(100) [default: NULL]
  "created_at" timestamp [not null, default: `current_timestamp()`]
  "updated_at" timestamp [not null, default: `current_timestamp()`]
}

Ref "carts_ibfk_1":"users"."id" < "carts"."idUser"

Ref "carts_ibfk_2":"products"."id" < "carts"."idProduct"

Ref "groups_ibfk_1":"users"."id" < "groups"."idGroupLeader"

Ref "participations_ibfk_1":"users"."id" < "participations"."idUser"

Ref "participations_ibfk_2":"groups"."id" < "participations"."idGroup"

Ref "products_ibfk_1":"groups"."id" < "products"."idGroup"
