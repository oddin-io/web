FROM node

RUN useradd --shell /bin/bash --create-home app
USER app

ENV INSTALL_PATH=/home/app

WORKDIR $INSTALL_PATH
COPY ["package.json", "bower.json", ".bowerrc", "./"]
RUN npm install

COPY . .
EXPOSE 3000

CMD npm start
