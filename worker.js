const fs = require('fs');
const wav = require('wav-decoder');

// อ่านไฟล์ WAV
const wavFilePath = 'path/to/your/file.wav';
const wavBuffer = fs.readFileSync(wavFilePath);

// แปลงข้อมูลเสียงใน WAV
wav.decode(wavBuffer).then((audioData) => {
    // ดำเนินการเพื่อทำให้ข้อมูลเสียงเหมาะสมกับไฟล์ BIN ที่คุณต้องการ
    const rawData = audioData.channelData[0]; // ข้อมูลเสียง raw จากช่องเสียงที่ 1 (สำหรับ mono)

    // ต่อไปคือตัวอย่างเพิ่มเติม
    // คุณอาจต้องแปลงข้อมูลเสียงให้เป็นทศนิยมหรือเป็นจำนวนเต็ม 8 บิต หรือ 16 บิต ตามความต้องการของคุณ
    // และจัดรูปแบบไฟล์ BIN ตามต้องการ

    // เขียนข้อมูลไปยังไฟล์ BIN
    const binFilePath = 'path/to/your/output/file.bin';
    fs.writeFileSync(binFilePath, Buffer.from(rawData));

    console.log('แปลงไฟล์ WAV เป็น BIN เสร็จเรียบร้อย');
}).catch((err) => {
    console.error('เกิดข้อผิดพลาดในการอ่านไฟล์ WAV:', err);
});
