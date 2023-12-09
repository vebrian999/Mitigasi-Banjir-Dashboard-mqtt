import mqtt from "mqtt";
import EventEmitter from "events";

const eventEmitter = new EventEmitter();

// MQTT settings
const mqttBroker = "broker.mqttdashboard.com";
const mqttPort = 1883;
const mqttTopic = "wokwi-banjir";

// Create MQTT client
const mqttClient = mqtt.connect({
  host: mqttBroker,
  port: mqttPort,
  clientId: `mqtt-client-${Math.random().toString(16).substr(2, 8)}`, // Generate a random client ID
});

// Callbacks
mqttClient.on("connect", () => {
  console.log("Connected to MQTT");
  mqttClient.subscribe(mqttTopic, (err) => {
    if (err) {
      console.error(`Error subscribing to ${mqttTopic}: ${err}`);
    } else {
      console.log(`Subscribed to ${mqttTopic}`);
    }
  });
});

mqttClient.on("message", (topic, message) => {
  console.log(`Received message on topic ${topic}: ${message}`);
  // Emit the message to be captured by other parts of the code
  eventEmitter.emit("mqttMessage", message.toString());
});

// Handle errors
mqttClient.on("error", (err) => {
  console.error("MQTT error:", err);
  // You can handle errors or reconnect to the MQTT broker here
  // For simplicity, we'll just log the error for now
});

export { eventEmitter, mqttClient };
