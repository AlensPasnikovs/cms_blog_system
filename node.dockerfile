#Nodes
FROM node:18-alpine as node

WORKDIR /var/www
COPY . .

RUN npm install --global cross-env
RUN npm install

VOLUME "/var/www/node_modules"
