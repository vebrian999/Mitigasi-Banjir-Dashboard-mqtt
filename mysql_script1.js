import mysql from "mysql";
import { eventEmitter } from "./mqtt_script.js";

// MySQL settings
const mysqlHost = "localhost";
const mysqlUser = "root";
const mysqlPassword = "";
const mysqlDatabase = "banjir";

// Create MySQL connection
const mysqlConnection = mysql.createConnection({
  host: mysqlHost,
  user: mysqlUser,
  password: mysqlPassword,
  database: mysqlDatabase,
});

// Connect to MySQL
mysqlConnection.connect((err) => {
  if (err) {
    console.error("Error connecting to MySQL:", err);
  } else {
    console.log("Connected to MySQL");
  }
});

// Example: Create a table
const createTableQuery = `
    CREATE TABLE IF NOT EXISTS databanjir1 (
        id INT AUTO_INCREMENT PRIMARY KEY,
        waktu TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        jarak_air_cm FLOAT NOT NULL,
        status VARCHAR(255) NOT NULL
    );
`;

mysqlConnection.query(createTableQuery, (err) => {
  if (err) {
    console.error("Error creating table:", err);
  } else {
    console.log("Table created successfully");
  }
});

// Process and insert data into MySQL when MQTT message is received
eventEmitter.on("mqttMessage", (message) => {
  console.log(`Received message from MQTT: ${message}`);

  // Assuming the MQTT message is a JSON string with "Jarak_Air_cm" and "Status" properties
  try {
    const { Jarak_Air_cm, Status } = JSON.parse(message);

    // Check if the received data is not null and not undefined before inserting into MySQL
    if (Jarak_Air_cm !== undefined && Status !== undefined && Jarak_Air_cm !== null && Status !== null) {
      // Insert data into MySQL with the current timestamp
      const insertDataQuery = "INSERT INTO databanjir1 (jarak_air_cm, status) VALUES (?, ?)";
      mysqlConnection.query(insertDataQuery, [Jarak_Air_cm, Status], (err) => {
        if (err) {
          console.error("Error inserting data into MySQL:", err);
        } else {
          console.log("Data inserted into MySQL");
        }
      });
    } else {
      console.error("Received invalid values for Jarak_Air_cm or Status from MQTT. Cannot insert into MySQL.");
    }
  } catch (error) {
    console.error("Error parsing MQTT message:", error);
  }
});
