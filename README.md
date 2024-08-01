# App Laravel

This repository contains a Laravel application

## 🚀 Installation

**To install the application on your machine, follow the steps below:**

```bash
git clone https://github.com/oGuilherme1/place-api/tree/master
```

```bash
cp .env.example .env
```
Set these values ​​in your .env with your data
- DB_DATABASE=your_database `Default: laravel`
- DB_USERNAME=your_username `Default: root`
- DB_PASSWORD=your_password `Default: r00t`

```bash
docker-compose up -d
```

```bash
docker exec -it laravel_SGBr bash
```

```bash
php artisan key:generate
```

Wait a few seconds for the laravel server to start, otherwise the command below displays a connection error

```bash
php artisan migrate
```

```bash
php artisan test
```

Access the page [http://localhost:8000](http://localhost:8000) in your browser.

## 📡 Endpoints 

#### Create Place

- **Method**: POST
- **URL**: http://localhost:8000/api/place

```json
{
	"name": "teste name",
	"city": "teste city",
	"state": "teste state"
}
```


#### Update Place

- **Method**: PUT
- **URL**: http://localhost:8000/api/place

```json
{
	"id": "308491ff-ff47-4399-a665-18e8076c7d5r",
	"name": "teste name",
	"city": "teste city",
	"state": "teste state"
}
```


#### Get All Place 

- **Method**: GET
- **URL**: http://localhost:8000/api/place

```json
{

}
```


#### Get Place With Name Filter

- **Method**: GET
- **URL**: http://localhost:8000/api/place/teste

```json
{

}
```


#### Get Specific Place

- **Method**: GET
- **URL**: http://localhost:8000/api/place/specific/308491ff-ff47-4399-a665-18e8076c7d5r

```json
{
}
```

## 🛠️ Technologies Used

- PHP (version 8.2)
- Laravel (version 10)
- PostgreSQL (latest version from Docker)
