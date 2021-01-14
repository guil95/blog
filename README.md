# How to use

## 1 - Install dependencies
```
composer install
```

## 2 - Stand up the container

```
cd docker && docker-compose up
```

## 3 - Stand up the container

```
cp .env-example .env
```

## 4 - Update hosts to url

```
sudo nano /etc/hosts add 127.0.0.1 blog.local 
```

## 5 - Execute migrate and seeds

```
  composer migrate && composer seed
```
