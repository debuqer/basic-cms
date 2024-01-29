## About Project

This is a basic cms, written in PHP, based on Laravel and FilamentPHP. This project aims to satisfy these requirements:

- two types of users: author and admin
- author can create, and update article
- admin can publish articles
- admin can draft articles
- admin can delete and restore articles
- etc

## Installation

This project provides a MakeFile for easier installation

Clone the project
```shell
git clone git@github.com:debuqer/basic-cms.git
```

or 

```shell
git clone https://github.com/debuqer/basic-cms.git
```

And installation can be done by this make command

```shell
make install
```

**Note:** Install command is responsible to facilate installation process, so it will copy .env.example in .env, If you wish to customize the configuration before install, change .env.example or run commands manually.


## Usage

To login as an author, go to http://localhost:8088/author

---
**Username**: author@local.dev

**Password**: password

---

In order to login as an admin, go to http://localhost:8088/admin

---
**Username**: admin@local.dev

**Password**: password

---

## Contributer

MohammadBagher Abbasi

bagher2g@gmail.com

debuqer@gmail.com
