<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


**Installation and Setup**

**Prerequisites:**

- Docker Desktop installed on your local machine.

**Note:**

- The provided Docker Compose configuration is intended for local development and **not optimized for production use**.
- A decryption key is required to build the Laravel container. This key is provided separately via email.

**1. Build the Containers:**

```bash
docker-compose build --build-arg DECRYPTION_KEY=KEY_FROM_EMAIL_GOES_HERE 
```

**2. Start the Containers:**

```bash
docker-compose up -d
```

**3. Access the Application:**

- The React frontend application is built using React and Vite as build tool and is accessible at: `http://localhost:4173`

**Application Features:**

- Includes a Registration page.
- Includes a Login page.
- Provides a page to view news.

**Data Management:**

- **Import Fresh Data:**

  1. Access the container's shell:

     ```bash
     docker exec -it laravel /bin/bash
     ```

  2. Run the following artisan command from the project root within the container:

     ```bash
     php artisan app:scrap-latest-news
     ```

- **Refresh Database:**

  ```bash
  php artisan migrate:fresh
  ```



## API

Use `Assessment.postman_collection.json` file present in project tool to import API collections



## Screenshot

![image-20241228034942489](C:\Users\LENOVO\AppData\Roaming\Typora\typora-user-images\image-20241228034942489.png)



![image-20241228035146520](C:\Users\LENOVO\AppData\Roaming\Typora\typora-user-images\image-20241228035146520.png)



![image-20241228035215599](C:\Users\LENOVO\AppData\Roaming\Typora\typora-user-images\image-20241228035215599.png)

![image-20241228035258020](C:\Users\LENOVO\AppData\Roaming\Typora\typora-user-images\image-20241228035258020.png)
