# Use official MySQL image as base.
FROM mysql:latest

# Copy the init SQL script to the Docker Entrypoint.
# It runs on First MySQL start to setup datbase, users, and tables.
COPY init.sql /docker-entrypoint-initdb.d/

# Expose MySQL port.
EXPOSE 3306