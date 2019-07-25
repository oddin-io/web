FROM node:8.16-jessie

RUN npm install -g webpack

WORKDIR /home/app
COPY ["package.json", "package-lock.json", "gulpfile.js", "webpack.config.js", "fileMappings.js", "./"]

RUN npm install

COPY . .
EXPOSE 3000

RUN npm run build
CMD npm start
