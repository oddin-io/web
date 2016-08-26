FROM node

ENV INSTALL_PATH=/app

WORKDIR $INSTALL_PATH
COPY package.json package.json
RUN npm install

COPY . .
EXPOSE 3000

CMD npm start
