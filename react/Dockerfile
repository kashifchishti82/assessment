FROM node:18-alpine

WORKDIR /app

# Copy package.json
COPY ./react/ ./

# Install dependencies
RUN npm install

# Copy the rest of the application code
COPY . .

# Build the React application
RUN npm run build

# Expose the port for the frontend server (e.g., 3000)
EXPOSE 4173

# Start the frontend server (replace with your actual command)
CMD ["npm","run", "preview"]