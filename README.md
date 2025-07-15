# Multi-Service Application

This project is a multi-service application consisting of a PHP web application, a MySQL database, and a Redis cache. The services are containerized using Docker and orchestrated with Docker Compose.

## Prerequisites

- [Docker](https://docs.docker.com/get-docker/) installed on your machine.
- [Docker Compose](https://docs.docker.com/compose/install/) installed.

## Setup and Run

1. **Clone the repository:**

   ```bash
   git clone https://github.com/rajdeep11/multi-service-app.git
   ```

2. **Navigate to the project directory:**

   ```bash
   cd multi-service-app
   ```

3. **Build and start the services:**

   ```bash
   docker-compose up --build -d
   ```

4. **Verify the services are running:**

   ```bash
   docker-compose ps
   ```

## Accessing the Application

- Open your web browser and go to [http://localhost:8080](http://localhost:8080) to access the PHP application status page.

## Services Details

- **PHP Web Application:**
  - Runs on port `8080` (mapped to container port 80).
  - Built from the `php-app` directory.
  - Connects to MySQL and Redis services using environment variables.

- **MySQL Database:**
  - Runs on port `3306`.
  - Credentials:
    - User: `admin`
    - Password: `admin123`
    - Database: `mydatabase`
  - Data is persisted in a Docker volume named `db_data`.
  - Initialized with a sample table and data from `mysql/init.sql`.

- **Redis Cache:**
  - Runs on port `6370` (mapped to container port 6379).
  - Used as a caching layer by the PHP application.

## Data Persistence

- MySQL data is persisted using a Docker named volume (`db_data`) to ensure data is not lost when containers are stopped or removed.

## Environment Variables

The following environment variables are set in the `docker-compose.yml` file for the PHP application:

- `MYSQL_HOST`: Hostname of the MySQL service (`db`).
- `MYSQL_USER`: MySQL username (`admin`).
- `MYSQL_PASSWORD`: MySQL user password (`admin123`).
- `MYSQL_DATABASE`: MySQL database name (`mydatabase`).
- `REDIS_HOST`: Hostname of the Redis service (`cache`).
- `REDIS_PORT`: Redis port (`6379`).

## Stopping the Application

To stop and remove the running containers, use:

```bash
docker-compose down
```

---

This README provides all the necessary steps to set up and run the multi-service application using Docker Compose.
