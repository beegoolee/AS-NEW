FROM node:alpine

WORKDIR /app

COPY jsconfig.json .
COPY package.json .
COPY vite.config.js .
COPY index.html .
COPY src/ ./src
COPY .gitignore .

RUN npm install

EXPOSE 5173

CMD ["npm", "run", "dev"]