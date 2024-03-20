const express = require("express");
const mysql = require("mysql");
const app = express();
app.use(express.json()); // เปิดใช้ middleware express.json()
const con = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "root",
  database: "smart_apartment_system",
  port: "8889",
});
app.listen(3000, () => console.log("Server running"));

con.connect((err) => {
  if (err) {
    console.log("Error connecting to database:", err);
    return;
  }
  console.log("Connected to MySQL database!");
});

app.put("/update/:id", (req, res) => {
  const id = req.params.id; // รับค่า id จาก URL parameters
  const newData = req.body; // ข้อมูลใหม่ที่ต้องการอัปเดต

  // ทำการอัปเดตข้อมูลในฐานข้อมูล
  con.query(
    "UPDATE s_power_meter SET  ? WHERE p_id = ?",
    [newData, id],
    (err, result) => {
      if (err) {
        console.error("Error updating data:", err);
        res.status(500).send("Error updating data");
        console.log(newData);
        return;
      }
      console.log("Data updated successfully", result);
      res.send("Data updated successfully");
    }
  );
});
app.put("/update_water/:id", (req, res) => {
  const id = req.params.id; // รับค่า id จาก URL parameters
  const newData = req.body; // ข้อมูลใหม่ที่ต้องการอัปเดต

  // ทำการอัปเดตข้อมูลในฐานข้อมูล
  con.query(
    "UPDATE s_water_meter SET  ? WHERE w_id = ?",
    [newData, id],
    (err, result) => {
      if (err) {
        console.error("Error updating data:", err);
        res.status(500).send("Error updating data");
        console.log(newData);
        return;
      }
      console.log("Data updated successfully", result);
      res.send("Data updated successfully");
    }
  );
});

app.get("/get", (req, res) => {
  // เพิ่มพารามิเตอร์ id เข้าไปใน URL parameters
  const id = req.params.id; // รับค่า id จาก URL parameters
  // ทำการค้นหาข้อมูลในฐานข้อมูล
  con.query(
    "SELECT * FROM s_power_meter WHERE emb_id != 0 && addr != 0",
    (err, result) => {
      if (err) {
        console.error("Error fetching data:", err);
        res.status(500).send("Error fetching data");
        return;
      }
      console.log("Data fetched successfully", result);
      res.send(result); // ส่งข้อมูลที่ได้รับมากลับไปให้ผู้ใช้
    }
  );
});

app.get("/get_water", (req, res) => {
  // เพิ่มพารามิเตอร์ id เข้าไปใน URL parameters
  const id = req.params.id; // รับค่า id จาก URL parameters
  // ทำการค้นหาข้อมูลในฐานข้อมูล
  con.query(
    "SELECT * FROM s_water_meter WHERE emb_id != 0 && addr != 0",
    (err, result) => {
      if (err) {
        console.error("Error fetching data:", err);
        res.status(500).send("Error fetching data");
        return;
      }
      console.log("Data fetched successfully", result);
      res.send(result); // ส่งข้อมูลที่ได้รับมากลับไปให้ผู้ใช้
    }
  );
});
const convert = require("xml-js");

//ไฟ
// เรียกใช้ฟังก์ชันเมื่อโหลดหน้า
fetchMeterData();

// ตั้งเวลาให้เรียกใช้ฟังก์ชันทุก 5 นาที
setInterval(fetchMeterData, 5 * 60 * 1000);

function fetchMeterData() {
  fetch("http://localhost:3000/get")
    .then((response) => response.json())
    .then((data) => {
      getmeter(data);
    })
    .catch((error) => console.error("Error:", error));
}

function getmeter(data) {
  for (let index = 0; index < data.length; index++) {
    console.log("data:", data[index].emb_id);
    console.log("data:", data[index].addr);
    //ไฟ
    fetch(
      `http://cloud.sunelectricsupply.co.th/SSmart/Apartment/SS_API.php?function=power_display()&emb_id=${data[index].emb_id}&addr=${data[index].addr}`
    )
      .then((response) => {
        if (!response.ok) {
          throw new Error("เกิดข้อผิดพลาดในการรับข้อมูล");
        }
        return response.text();
      })
      .then((xmlData) => {
        // แปลง XML เป็น JSON
        const jsonData = convert.xml2json(xmlData, {
          compact: true,
          spaces: 2,
        });
        kwhValue = JSON.parse(jsonData).LOGGER.ITEM.KWH._text;
        doSomethingWithKWH(kwhValue, data[index].p_id); // ฟังก์ชัน doSomethingWithKWH() รับค่า kwhValue เพื่อใช้งาน
      })
      .catch((error) => {
        console.error("เกิดข้อผิดพลาด:", error);
      });

    function doSomethingWithKWH(kwh, p_id) {
      console.log("ค่า KWH ที่ใช้งาน:", kwh);
      fetch("http://localhost:3000/update/" + p_id, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          p_kwh: kwh,
        }),
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("เกิดข้อผิดพลาดในการส่งคำขอ");
          }
          return response.json();
        })
        .then((data) => {
          console.log("รับข้อมูลจากเซิร์ฟเวอร์:", data);
        })
        .catch((error) => {});
    }
  }
}
//ไฟ

//นำ้
// เรียกใช้ฟังก์ชันเมื่อโหลดหน้า
fetchWaterMeterData();

// ตั้งเวลาให้เรียกใช้ฟังก์ชันทุก 5 นาที
setInterval(fetchWaterMeterData, 5 * 60 * 1000);
function fetchWaterMeterData() {
  fetch("http://localhost:3000/get_water")
    .then((response) => response.json())
    .then((data) => {
      getWaterMeter(data);
    })
    .catch((error) => console.error("Error:", error));
}

function getWaterMeter(data) {
  for (let index = 0; index < data.length; index++) {
    fetch(
      `http://cloud.sunelectricsupply.co.th/SSmart/Apartment/SS_API.php?function=water_display()&emb_id=${data[index].emb_id}&addr=${data[index].addr}`
    )
      .then((response) => {
        if (!response.ok) {
          throw new Error("เกิดข้อผิดพลาดในการรับข้อมูล");
        }
        return response.text();
      })
      .then((xmlData) => {
        const jsonData = convert.xml2json(xmlData, {
          compact: true,
          spaces: 2,
        });
        const FLOW_SUM = JSON.parse(jsonData).LOGGER.ITEM.FLOW_SUM._text;
        doSomethingWithFLOW_SUM(FLOW_SUM, data[index].w_id);
      })
      .catch((error) => {
        console.error("เกิดข้อผิดพลาด:", error);
      });

    function doSomethingWithFLOW_SUM(FLOW_SUM, w_id) {
      console.log("ค่า FLOW_SUM ที่ใช้งาน:", FLOW_SUM);
      fetch("http://localhost:3000/update_water/" + w_id, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          w_flow_sum: FLOW_SUM,
        }),
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("เกิดข้อผิดพลาดในการส่งคำขอ");
          }
          return response.json();
        })
        .then((data) => {
          console.log("รับข้อมูลจากเซิร์ฟเวอร์:", data);
        })
        .catch((error) => {
          console.error("เกิดข้อผิดพลาด:", error);
        });
    }
  }
}
//นำ้