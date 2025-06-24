## 📄 `README.md`

````markdown
# PDF Generator API

The **PDF Generator API** is a web service that provides a JSON API for generating PDF documents from HTML markup. It supports CSS3 rendering, custom fonts, images, and external stylesheets.


## 📌 Purpose

This service allows you to generate styled PDF files from HTML code. It’s useful for:

- Generating reports and invoices  
- Creating printable documents like certificates  
- Converting styled web content to PDF  
- Automating document generation from templates  


## 🚀 How to Launch the Project

## 1. Clone the repository

```bash
git clone https://github.com/your-username/pdf-generator-api.git
cd pdf-generator-api
````

### 2. Install dependencies

Make sure you have **PHP ≥ 8.1** and **Composer** installed.

```bash
composer install
```

### 3. Run the development server

Using Symfony CLI:

```bash
symfony server:start
```

Or with built-in PHP server:

```bash
php -S localhost:8000 -t public
```

The API will be available at:
**[http://localhost:8000](http://localhost:8080)**


---
## 📄 `Docker Deployment`

````markdown
## 🚢 Docker Deployment

You can run the project inside a Docker container for easy setup and isolation.

### Dockerfile

```Dockerfile
FROM debian:bookworm

LABEL authors="author"

RUN apt-get update \
    && apt-get install -y wkhtmltopdf

RUN apt-get -y update \
    && apt-get install -y php php-intl php-zip php-xml nginx php-fpm \
    && apt-get clean

COPY ./server.conf /etc/nginx/sites-available/default
EXPOSE 80

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html
COPY ./ ./ 
RUN composer install
RUN chmod 777 ./var -R 

CMD /etc/init.d/php8.2-fpm start && \
    nginx -g 'daemon off;'
````

### docker-compose.yml

```yaml
version: '3'

services:
  app:
    build: ./app
    ports:
      - "8080:80"
    volumes:
      - ./var/nginx:/var/log/nginx:rw
    environment:
      - APP_ENV=dev
```

---

### How to build and run

1. Place your application files including `Dockerfile` in the `./app` folder.
2. Run the following command to build and start the container:

```bash
docker-compose up --build
```

3. Open your browser and navigate to:
   `http://localhost:8080`

---

### Notes

* The container runs PHP-FPM and Nginx to serve the app.
* The PDF generation depends on `wkhtmltopdf` installed inside the container.
* Logs are mounted from the host directory `./var/nginx` for easier debugging.
* Adjust `APP_ENV` environment variable for production settings as needed.

---

## 📡 API Endpoints

### `POST /generator`

Generates a PDF document from HTML markup.

#### Request Headers

* `Content-Type: application/json`
* `Charset: utf-8`

#### Request Body

```json
{
  "html": "<h1>Hello PDF</h1>",
  "saveFile": true,
  "orientation": "portrait",
  "width": 210,
  "height": 297
}
```

| Parameter     | Type      | Required | Description                              |
| ------------- | --------- | -------- | ---------------------------------------- |
| `html`        | `string`  | ✅        | HTML content to render                   |
| `saveFile`    | `boolean` | ❌        | Save file on server (`false` by default) |
| `orientation` | `string`  | ❌        | `"portrait"` or `"landscape"`            |
| `width`       | `integer` | ❌        | Page width in mm (default: `210`)        |
| `height`      | `integer` | ❌        | Page height in mm (default: `297`)       |

#### Response

* If `saveFile = false`: returns PDF directly
* If `saveFile = true`: returns JSON response

```json
{
  "file_name": "example123.pdf"
}
```

---

### `GET /file?file_name=example123.pdf`

Returns the previously saved PDF file.

#### Parameters

* `file_name`: The file ID returned by the `/generator` endpoint.

#### Response

* Content-Type: `application/pdf`

## ✨ Features

- CSS3 support (`@import`, `@media`, `@page`, etc.)
- HTML 4.0 / 5.0 presentational attributes
- External and inline styles
- Complex table support (merged cells, individual styles, borders)
- Embedded and external images (GIF, PNG, JPEG, BMP, basic SVG)
- Custom page sizes and orientation
- Built-in fonts (`Helvetica`, `Times-Roman`, etc.)
- External fonts via `@font-face`
- Server-side saving and retrieval of generated files


## 📖 Example: Using External Fonts

```css
@import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

body {
    font-family: 'Roboto', sans-serif;
}
```

---

## ✅ Requirements

* PHP 8.1 or higher
* Composer
* Symfony CLI
* Docker(optional)

