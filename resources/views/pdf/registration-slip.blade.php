<!DOCTYPE html>
<html lang="hi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>पंजीयन पर्ची - {{ $registration->registration_number }}</title>
    <style>
        body { font-family: 'hind', sans-serif; font-size: 12px; color: #1a202c; line-height: 1.4; margin: 0; padding: 10px; }
        .header { background-color: #800020; color: #ffffff; padding: 12px; text-align: center; border-bottom: 4px solid #d97706; }
        .title { font-size: 18px; font-weight: bold; color: #fef3c7; margin-bottom: 4px; }
        .subtitle { font-size: 12px; color: #fde68a; }
        .reg-box { background-color: #fffbeb; border: 2px solid #d97706; padding: 8px; margin: 12px 0; text-align: center; }
        .reg-no { font-size: 20px; font-weight: bold; color: #800020; }
        .table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        .table th, .table td { border: 1px solid #cbd5e1; padding: 6px 8px; text-align: left; }
        .table th { background-color: #f1f5f9; font-weight: bold; width: 35%; color: #334155; }
        .qr-section { text-align: center; margin-top: 10px; }
        .qr-img { width: 130px; height: 130px; }
        .rules-box { background-color: #fef2f2; border: 1px solid #fca5a5; padding: 8px; margin-top: 10px; font-size: 10px; color: #991b1b; }
        .footer { font-size: 9px; text-align: center; color: #64748b; margin-top: 15px; border-t: 1px solid #e2e8f0; padding-top: 4px; }
    </style>
</head>
<body>

    <div class="header">
        <div class="title">33वाँ श्रावक संस्कार शिविर – अशोकनगर 2026</div>
        <div class="subtitle">पुण्योदय भारत | आधिकारिक प्रवेश एवं पंजीयन पर्ची</div>
    </div>

    <div class="reg-box">
        <div style="font-size: 11px; color: #92400e; font-weight: bold;">पंजीयन संख्या (Registration ID)</div>
        <div class="reg-no">{{ $registration->registration_number }}</div>
    </div>

    <table class="table">
        <tr>
            <th>शिविरार्थी का पूरा नाम</th>
            <td><strong>{{ $registration->participant->full_name }}</strong></td>
        </tr>
        <tr>
            <th>पिता का नाम</th>
            <td>{{ $registration->participant->father_name }}</td>
        </tr>
        <tr>
            <th>आयु एवं जन्मतिथि</th>
            <td>{{ $registration->participant->age }} वर्ष ({{ $registration->participant->dob->format('d-m-Y') }})</td>
        </tr>
        <tr>
            <th>पंजीकृत मोबाइल नंबर</th>
            <td>{{ $registration->participant->mobile }}</td>
        </tr>
        <tr>
            <th>स्थाई पता</th>
            <td>{{ $registration->participant->address }}, {{ $registration->participant->city }}, {{ $registration->participant->district }} ({{ $registration->participant->state }})</td>
        </tr>
        <tr>
            <th>आपातकालीन संपर्क</th>
            <td>{{ $registration->participant->emergency_contact_name }} ({{ $registration->participant->emergency_contact_number }})</td>
        </tr>
        <tr>
            <th>शिविर स्थल</th>
            <td>{{ $registration->shivir->venue }}</td>
        </tr>
    </table>

    <div class="qr-section">
        <img src="{{ $qrDataUri }}" class="qr-img"><br>
        <strong style="font-size: 10px; color: #475569;">सत्यापन एवं आवास आवंटन क्यूआर कोड (QR Token)</strong>
    </div>

    <div class="rules-box">
        <strong>महत्वपूर्ण निर्देश:</strong> यह शिविर केवल पुरुष वर्ग हेतु है। शिविर अवधि (10 दिन) के दौरान मोबाइल फोन, स्मार्टवॉच एवं इलेक्ट्रॉनिक उपकरणों का उपयोग/रखना सख्त मना है। शिविर स्थल पर आगमन पर यह पर्ची अथवा डिजिटल क्यूआर कोड दिखाना अनिवार्य है।
    </div>

    <div class="footer">
        © {{ date('Y') }} पुण्योदय भारत - Sanskar Shivir Digital Management System | Helpline: +91 94251 23456
    </div>

</body>
</html>
