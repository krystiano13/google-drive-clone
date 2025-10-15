FROM node:22-alpine
WORKDIR /app
COPY package.json .
RUN npm i -g pnpm
RUN pnpm i
RUN apk add --no-cache libc6-compat
COPY . .
EXPOSE 5173
CMD ["pnpm", "run", "dev"]
