# How to use

## 1 - Create the project
``` 
composer create-project guil95/api-sample --prefer-source <folder>
```

## 2 - Install dependencies
```
composer install
```

## 3 - Stand up the container

```
cd docker && docker-compose up
```

## 4 - Stand up the container

```
cp .env-example .env
```

## 5 - Update hosts to url

```
sudo nano /etc/hosts add 127.0.0.1 blog.local 
```

## 6 - Execute migrate and seeds

```
  composer migrate && composer seed
```
