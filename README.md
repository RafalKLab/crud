# rklab/crud laravel package
Package for Laravel 9 with GUI to automatically generate CRUD

[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)
[![MIT License](https://github.styleci.io/repos/7548986/shield?style=plastic)](https://github.com/RafalKLab/crud)


#### CRUD generation panel is accesable by route

```http
  https://<<APP_URL>>/crud
```

#### Features
- Model, Migration, Controller and View generation using GUI
- Configurable pagination
- Model realtionship creation

#### Requirements
This package is intended for Laravel 9, it requires:
- Laravel 9 environment
- Relational database

#### How to install

```bash
  composer require rklab/crud
```

```bash
  php artisan vendor:publish --provider="Rklab\Crud\Providers\CrudServiceProvider"
```

```bash
  php artisan migrate
```

