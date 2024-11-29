FROM Node17-alpine;

WORKDIR /Image

COPY . . 

RUN npm install

EXPOSE 4000

CMD ["npm", "start", "build"]