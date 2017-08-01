FROM node

RUN useradd --user-group --shell /bin/sh --create-home app &&\
    npm install -g webpack

ENV INSTALL_PATH=/home/app

WORKDIR $INSTALL_PATH
COPY ["package.json", "package-lock.json", "gulpfile.js", "webpack.config.js", "fileMappings.js", "./"]
RUN chown -R app:app ./*

USER app
WORKDIR $INSTALL_PATH
RUN npm install

USER root
COPY . .
RUN chown -R app:app ./*
EXPOSE 3000

USER app
RUN npm run build
CMD npm start
