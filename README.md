

This project use the following ports:

| Tech  | Port |
|-------|-----:|
| Nginx | 1111 |
| MySQL | 1112 |

### Usage:

[Postman Collection](https://www.postman.com/spaceflight-technologist-30482878/workspace/treetest/overview)

### Installation:

**1- Clone:**

```bash
git clone https://github.com/Burashev/TreeTest.git
```

2- **Open project folder:**

```bash
cd TreeTest
```

3-  **Copy** `.env` **:**

```bash
cp .env.example .env
```

4- **Docker:**

```bash
docker-compose build
```
```bash
docker-compose up -d
```
```bash
docker-compose exec app composer install
```
```bash
docker-compose exec app php artisan key:generate
```
```bash
docker-compose exec app php artisan migrate --seed
```

Open [localhost:1111](http://localhost:1111)
