<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WAV to BIN Converter</title>
</head>

<body>
    <h1>WAV to BIN Converter</h1>
    <input type="file" id="wavInput1" accept=".wav">
    <input type="file" id="wavInput2" accept=".wav">
    <input type="file" id="wavInput3" accept=".wav">
    <input type="file" id="wavInput4" accept=".wav">
    <input type="file" id="wavInput5" accept=".wav">
    <button onclick="convertToBin()">Convert to BIN</button>
    <button onclick="downloadBin()">Download BIN</button>

    <script>
        let wavFiles = [];

        function convertToBin() {
            wavFiles = [];

            for (let i = 1; i <= 5; i++) {
                const inputElement = document.getElementById(`wavInput${i}`);
                if (inputElement.files.length > 0) {
                    wavFiles.push(inputElement.files[0]);
                }
            }

            if (wavFiles.length > 0) {
                let totalSize = 0;
                const buffers = [];

                for (const file of wavFiles) {
                    totalSize += file.size;

                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const arrayBuffer = e.target.result;
                        const samples = new Int16Array(arrayBuffer);

                        // นำไฟล์ .wav มาแปลงเป็น .bin
                        const binData = new Uint8Array(samples.length * 2); // จำนวนไบต์จะเท่ากับจำนวนตัวอย่างคูณ 2
                        for (let i = 0; i < samples.length; i++) {
                            // เพิ่มข้อมูลจาก Int16Array เข้าไปใน Uint8Array
                            binData[i * 2] = samples[i] & 0xFF;
                            binData[i * 2 + 1] = (samples[i] >> 8) & 0xFF;
                        }
                        buffers.push(binData);
                    };

                    reader.readAsArrayBuffer(file);
                }

                if (totalSize <= 20 * 1024 * 1024) {
                    // รวมข้อมูลจากไฟล์ทั้งหมด
                    const mergedData = new Uint8Array(totalSize);
                    let offset = 0;

                    for (const buffer of buffers) {
                        mergedData.set(buffer, offset);
                        offset += buffer.length;
                    }

                    // เก็บไว้ในตัวแปร window.binData (สามารถใช้เมื่อต้องการดาวน์โหลด)
                    window.binData = mergedData;

                    alert('Conversion complete. You can now download the BIN file.');
                } else {
                    alert('Total file size exceeds 4 MB. Please upload files with a total size of 4 MB or less.');
                }
            } else {
                alert('Please select at least one WAV file.');
            }
        }

        function downloadBin() {
            if (window.binData) {
                const blob = new Blob([window.binData], {
                    type: 'application/octet-stream'
                });
                const url = URL.createObjectURL(blob);

                const a = document.createElement('a');
                a.href = url;
                a.download = 'output.bin';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            } else {
                alert('Please convert WAV to BIN first.');
            }
        }
    </script>
</body>

</html>