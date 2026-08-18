<!DOCTYPE html>
<html lang="hi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>संस्कार शिविर प्रमाण पत्र - {{ $certificate->certificate_number }}</title>
    <style>
        body { font-family: 'hind', sans-serif; text-align: center; color: #1a202c; padding: 15px; background-color: #fdfbf7; }
        .cert-border { border: 8px solid #800020; padding: 25px; border-radius: 15px; background: #ffffff; }
        .cert-title { font-size: 26px; font-weight: bold; color: #800020; margin-bottom: 8px; }
        .cert-subtitle { font-size: 15px; color: #d97706; font-weight: bold; margin-bottom: 20px; }
        .recipient { font-size: 22px; font-weight: bold; color: #1e293b; margin: 12px 0; border-bottom: 2px solid #cbd5e1; display: inline-block; padding-bottom: 4px; }
        .text { font-size: 13px; line-height: 1.5; color: #334155; margin: 15px 30px; }
        .qr-box { margin-top: 15px; }
        .qr-img { width: 90px; height: 90px; }
        .footer { font-size: 10px; color: #94a3b8; margin-top: 20px; }
    </style>
</head>
<body>

    <div class="cert-border">
        <div class="cert-title">प्रमाण पत्र (Certificate of Completion)</div>
        <div class="cert-subtitle">33वाँ श्रावक संस्कार शिविर – अशोकनगर 2026</div>

        <p class="text">प्रमाणित किया जाता है कि श्रावक</p>
        <div class="recipient">{{ $certificate->registration->participant->full_name }}</div>
        <p class="text">
            ने परम पूज्य निर्यापक श्रमण मुनिश्री 108 सुधासागर जी महाराज के पावन सानिध्य में आयोजित 10 दिवसीय वार्षिक संस्कार शिविर में निष्ठापूर्वक भाग लेकर धर्म, संयम एवं स्वाध्याय संस्कारों को आत्मसात किया।
        </p>

        <div class="qr-box">
            <img src="{{ $qrDataUri }}" class="qr-img"><br>
            <span style="font-size: 9px; color: #64748b;">प्रमाण पत्र संख्या: {{ $certificate->certificate_number }}</span>
        </div>

        <div class="footer">
            आयोजक: पुण्योदय भारत एवं सकल दिगंबर जैन समाज अशोकनगर (म.प्र.)
        </div>
    </div>

</body>
</html>
