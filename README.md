docker build -t tda-image .
docker run -d --name tea -p 8080:80 -v "C:\Users\filip\Downloads\TdA25-Panska-main (1)\TdA25-Panska-main\php:/var/www/html" tda-image