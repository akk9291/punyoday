<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Shivir;
use App\Models\ShivirSection;
use App\Models\ShivirSectionItem;
use App\Models\ShivirRule;
use App\Models\ShivirFaq;
use App\Models\ShivirSchedule;
use App\Models\Announcement;
use App\Models\Participant;
use App\Models\Registration;
use App\Models\AccommodationBlock;
use App\Models\AccommodationRoom;
use App\Models\AccommodationBed;
use App\Models\RoomAllocation;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\AttendanceSession;
use App\Models\AttendanceRecord;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SanskarShivirSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Users for all roles
        $users = [
            [
                'name' => 'सुपर एडमिन (Super Admin)',
                'email' => 'superadmin@punyodaya.in',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'phone' => '9876543210',
            ],
            [
                'name' => 'शिविर प्रशासक (Admin)',
                'email' => 'admin@punyodaya.in',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '9876543211',
            ],
            [
                'name' => 'पंजीयन प्रबंधक (Reg Manager)',
                'email' => 'regmanager@punyodaya.in',
                'password' => Hash::make('password'),
                'role' => 'registration_manager',
                'phone' => '9876543212',
            ],
            [
                'name' => 'आवास प्रबंधक (Room Manager)',
                'email' => 'roommanager@punyodaya.in',
                'password' => Hash::make('password'),
                'role' => 'accommodation_manager',
                'phone' => '9876543213',
            ],
            [
                'name' => 'उपस्थिति प्रबंधक (Attendance)',
                'email' => 'attendancemanager@punyodaya.in',
                'password' => Hash::make('password'),
                'role' => 'attendance_manager',
                'phone' => '9876543214',
            ],
            [
                'name' => 'स्वयंसेवक (Volunteer Staff)',
                'email' => 'volunteer@punyodaya.in',
                'password' => Hash::make('password'),
                'role' => 'volunteer',
                'phone' => '9876543215',
            ],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(['email' => $u['email']], $u);
        }

        // 2. Create Active Shivir 2026 - Indore
        $shivir2026 = Shivir::updateOrCreate(['slug' => 'sanskar-shivir-indore-2026'], [
            'name' => '33वाँ श्रावक संस्कार शिविर – इंदौर 2026',
            'shivir_number' => '33वाँ',
            'year' => 2026,
            'location' => 'इंदौर (म.प्र.)',
            'venue' => 'दलाल बाग़, छत्रपति नगर जैन मंदिर, इंदौर (म.प्र.)',
            'start_date' => '2026-09-16',
            'end_date' => '2026-09-25',
            'reg_start_date' => '2026-08-01',
            'reg_end_date' => '2026-09-15',
            'status' => 'registration_open',
            'max_limit' => 3500,
            'prefix' => 'IND-2026-',
            'contact_info' => 'हेल्पलाइन: +91 98260 12345, +91 94251 67890 | ईमेल: info@punyodaya.in',
            'is_male_only' => true,
            'description' => 'परम पूज्य निर्यापक श्रमण मुनिश्री 108 सुधासागर जी महाराज के मंगल सानिध्य में 10 दिवसीय वार्षिक 33वाँ श्रावक संस्कार शिविर का आयोजन इंदौर की पावन धरा पर किया जा रहा है।',
        ]);

        // Archive Shivir 2025 for multi-year archive demo
        Shivir::updateOrCreate(['slug' => 'sanskar-shivir-lalitpur-2025'], [
            'name' => '32वाँ श्रावक संस्कार शिविर – ललितपुर 2025',
            'shivir_number' => '32वाँ',
            'year' => 2025,
            'location' => 'ललितपुर (उ.प्र.)',
            'venue' => 'श्री दिगंबर जैन बड़ा मंदिर, ललितपुर',
            'start_date' => '2025-08-28',
            'end_date' => '2025-09-07',
            'reg_start_date' => '2025-08-01',
            'reg_end_date' => '2025-08-25',
            'status' => 'archived',
            'max_limit' => 2500,
            'prefix' => 'LAL-2025-',
            'contact_info' => 'सम्पर्क: 05176-277100',
            'is_male_only' => true,
            'description' => 'ललितपुर में आयोजित ऐतिहासिक 32वाँ संस्कार शिविर जिसमें 2,400 से अधिक श्रावकों ने धर्म लाभ प्राप्त किया।',
        ]);

        // 3. Create Dynamic CMS Sections for Shivir 2026
        $secPunyarjak = ShivirSection::create([
            'shivir_id' => $shivir2026->id,
            'title' => 'शिविर पुण्यार्जक परिवार',
            'subtitle' => 'सौभाग्यशाली मुख्य पुण्यार्जक एवं संयोजक परिवार',
            'description' => 'समस्त कोयला परिवार, भारत (देवरी | इंदौर | भोपाल | चन्द्रपुर | कटनी | बिलासपुर | नागपुर | दिल्ली | मुंबई)',
            'background' => 'bg-amber-50',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        ShivirSectionItem::create([
            'shivir_section_id' => $secPunyarjak->id,
            'name' => 'चामुण्डराय श्रीमंत सेठ आकाश - दीपिका, आरव एवं आद्विक जैन (इंदौर)',
            'designation' => 'शिविर पुण्यार्जक',
            'department' => 'सीमा - सतीश जी जैन (बिलासपुर)',
            'photo' => 'punyarjak/akash_jain.jpg',
            'sort_order' => 1,
        ]);

        ShivirSectionItem::create([
            'shivir_section_id' => $secPunyarjak->id,
            'name' => 'चामुण्डराय श्रीमंत सेठ आलोक - मधु, आश्रय एवं आर्यन जैन (इंदौर)',
            'designation' => 'शिविर मुख्य संयोजक',
            'department' => 'अर्चना - देवेन्द्र जी जैन (भोपाल)',
            'photo' => 'punyarjak/alok_jain.jpg',
            'sort_order' => 2,
        ]);

        $secWelcome = ShivirSection::create([
            'shivir_id' => $shivir2026->id,
            'title' => 'धर्मानुरागी बन्धुवर, सादर जय जिनेन्द्र!',
            'subtitle' => 'धर्मनगरी इंदौर (म.प्र.) में 33वें श्रावक संस्कार शिविर 2026 का मंगल आमंत्रण पत्र',
            'description' => "हमारे पुण्योदय से परम पूज्य प्रात: स्मरणीय महाकवि संत शिरोमणि आचार्य गुरुदेव श्री 108 विद्यासागर जी महाराज के आशीर्वाद एवं उनके आज्ञानुवर्ती शिष्य श्रावक संस्कार शिविरों के जनक परम पूज्य तीर्थचक्रवर्ती जगतपूज्य निर्यापक श्रमण मुनिपुंगवश्री 108 सुधासागर जी महाराज का पावन सानिध्य महती धर्म प्रभावना के साथ धर्मनगरी इंदौर में स्थापित हुआ है।\n\nभौतिकवादी संस्कार विहीन पाश्चात्य संस्कृति की ओर दौड़ने वाले युग को भारतीय प्राचीन धार्मिक संस्कृति से संस्कारित करने हेतु गुरुकुल परम्परा के आधार पर श्रावक संस्कार शिविर के प्रणेता (जनक) पूज्य मुनिपुंगवश्री ने सर्वप्रथम सन 1991 में ललितपुर वर्षायोग के समय दशलक्षण पर्व को दस दिवसीय शिविर का रूप देकर श्रावकों को ऐसा संस्कारित किया कि आधुनिक भौतिकता की तरफ दौड़ने वाला युवा वर्ग पुन: धर्म को अपने जीवन का अंग मानने लगा। तब से अब तक निरंतर यह शिविर 32 वर्ष पूर्ण करता हुआ, सारे जगत में धर्मसंस्कारों का शंखनाद कर रहा है।\n\nइस वर्ष 2026 में 33वाँ श्रावक संस्कार शिविर विशाल स्तर पर दलाल बाग़, छत्रपति नगर जैन मंदिर, इंदौर (मध्यप्रदेश) में दिनांक 16 सितम्बर 2026 बुधवार से 25 सितम्बर 2026 शुक्रवार तक आयोजित होने जा रहा है, जो अपना इतिहास स्वर्णांकित करेगा। आप भी इस अनुकरणीय संस्कार शिविर में प्रवेश लेकर अपना जीवन धन्य करें। इस परम धार्मिक अनुष्ठान में आपकी गरिमामय उपस्थिति सादर प्रार्थनीय है। इस दस दिवसीय ज्ञानगंगा में अवगाहन कर पुण्यार्जन कीजिये।",
            'background' => 'bg-white',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $secBlessing = ShivirSection::create([
            'shivir_id' => $shivir2026->id,
            'title' => 'पावन मंगल आशीर्वाद एवं सानिध्य',
            'subtitle' => 'पूज्य गुरुदेव का दिव्य संदेश',
            'description' => 'श्रावक के जीवन में धर्म, नियम, संयम और संस्कारों का बीजारोपण करने हेतु पूज्य मुनिश्री सुधासागर जी महाराज के मार्गदर्शन में आयोजित।',
            'background' => 'bg-amber-50',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        ShivirSectionItem::create([
            'shivir_section_id' => $secBlessing->id,
            'name' => 'परम पूज्य निर्यापक श्रमण मुनिश्री 108 सुधासागर जी महाराज',
            'designation' => 'सप्रेरणा एवं मंगल आशीर्वाद',
            'description' => 'दिगंबर जैन परंपरा के प्रखर वक्ता, युगप्रधान संत एवं श्रावक संस्कारों के प्रणेता।',
            'sort_order' => 1,
        ]);

        ShivirSectionItem::create([
            'shivir_section_id' => $secBlessing->id,
            'name' => 'परम पूज्य मुनिश्री 108 महासागर जी महाराज',
            'designation' => 'मंगल सानिध्य',
            'description' => 'पूज्य मुनिश्री के संघस्थ शिष्य।',
            'sort_order' => 2,
        ]);

        $secTeam = ShivirSection::create([
            'shivir_id' => $shivir2026->id,
            'title' => 'शिविर निर्देशक एवं प्रबन्ध समिति',
            'subtitle' => 'आयोजक एवं व्यवस्थापक मंडल - अशोकनगर',
            'description' => 'शिविर की सुचारू व्यवस्था एवं संचालन हेतु समर्पित समिति।',
            'background' => 'bg-maroon-900',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        $teamItems = [
            // Leadership / Advisers
            ['name' => "प्रतिष्ठा मार्तण्ड श्रद्धेय बा.ब्र. श्री प्रदीप भैया जी 'सुयश' (अशोकनगर)", 'designation' => 'शिविर परामर्शक', 'sort_order' => 1],
            ['name' => 'बा.ब्र. श्री विनोद भैया जी (आधारताल)', 'designation' => 'शिविर परामर्शक', 'sort_order' => 2],
            ['name' => 'श्री हुकुम काका (कोटा)', 'designation' => 'शिविर निर्देशक', 'sort_order' => 3],
            ['name' => 'श्री दिनेश गंगवाल (जयपुर)', 'designation' => 'शिविर निर्देशक', 'sort_order' => 4],

            // 1. शिविर संयोजक
            ['name' => 'विवेक जैन अमरोद', 'designation' => 'शिविर संयोजक', 'mobile' => '9425131927', 'sort_order' => 5],
            ['name' => 'विजय जैन धुर्रा', 'designation' => 'शिविर संयोजक', 'mobile' => '9826516524', 'sort_order' => 6],
            ['name' => 'गौरव जैन भारत', 'designation' => 'शिविर संयोजक', 'mobile' => '9826085846', 'sort_order' => 7],
            ['name' => 'गोलू जैन बाँझल', 'designation' => 'शिविर संयोजक', 'mobile' => '9926466384', 'sort_order' => 8],
            ['name' => 'निलेश जैन टिंकल', 'designation' => 'शिविर संयोजक', 'mobile' => '7566392777', 'sort_order' => 9],
            ['name' => 'पुनीत जैन (शानू श्रृंगार)', 'designation' => 'शिविर संयोजक', 'mobile' => '8269235537', 'sort_order' => 10],

            // 2. कलश बुकिंग व दान
            ['name' => 'सुनील अखाई (कोषाध्यक्ष)', 'designation' => 'कलश बुकिंग व दान', 'mobile' => '9832133140', 'sort_order' => 11],
            ['name' => 'CA अक्षय जैन अमरोद', 'designation' => 'कलश बुकिंग व दान', 'mobile' => '9685781520', 'sort_order' => 12],
            ['name' => 'सौरभ बाँझल', 'designation' => 'कलश बुकिंग व दान', 'mobile' => '7000279859', 'sort_order' => 13],
            ['name' => 'अतुल आनंद कटपीस', 'designation' => 'कलश बुकिंग व दान', 'mobile' => '7000438194', 'sort_order' => 14],

            // 3. आहार व त्यागीव्रती भोजनशाला
            ['name' => 'उमेश जैन सिंघई', 'designation' => 'आहार व त्यागीव्रती भोजनशाला', 'mobile' => '9425131253', 'sort_order' => 15],
            ['name' => 'संजय जैन मूडरा', 'designation' => 'आहार व त्यागीव्रती भोजनशाला', 'mobile' => '9406572824', 'sort_order' => 16],
            ['name' => 'निर्मल जैन मिर्ची', 'designation' => 'आहार व त्यागीव्रती भोजनशाला', 'mobile' => '9406988588', 'sort_order' => 17],
            ['name' => 'राजू जैन पिपरई', 'designation' => 'आहार व त्यागीव्रती भोजनशाला', 'mobile' => '9425132043', 'sort_order' => 18],

            // 4. आवास व्यवस्था
            ['name' => 'नितिन बज', 'designation' => 'आवास व्यवस्था', 'mobile' => '8982189222', 'sort_order' => 19],
            ['name' => 'निलेश बडकुल', 'designation' => 'आवास व्यवस्था', 'mobile' => '7000279402', 'sort_order' => 20],
            ['name' => 'कपिल जैन "मिर्ची"', 'designation' => 'आवास व्यवस्था', 'mobile' => '9407210841', 'sort_order' => 21],
            ['name' => 'प्रतीक जैन (सनी)', 'designation' => 'आवास व्यवस्था', 'mobile' => '9425429161', 'sort_order' => 22],
        ];

        foreach ($teamItems as $item) {
            ShivirSectionItem::create(array_merge(['shivir_section_id' => $secTeam->id], $item));
        }

        // Organizers, Nivedak and Vineet Section
        $secOrganizers = ShivirSection::create([
            'shivir_id' => $shivir2026->id,
            'title' => 'आयोजक समिति',
            'subtitle' => 'दिगंबर जैन धर्मप्रभावना समिति एवं सकल दिगंबर जैन समाज, इंदौर',
            'description' => 'शिविर के मुख्य आयोजक।',
            'background' => 'bg-maroon-900',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        $organizerItems = [
            ['name' => 'आयोजक – श्री दिगंबर जैन धर्मप्रभावना समिति 2026 इंदौर', 'designation' => 'आयोजक – श्री दिगंबर जैन धर्मप्रभावना समिति 2026 इंदौर', 'sort_order' => 1],
            ['name' => 'विनीत – सकल दिगंबर जैन समाज, इंदौर', 'designation' => 'विनीत – सकल दिगंबर जैन समाज, इंदौर', 'sort_order' => 2],
        ];

        foreach ($organizerItems as $item) {
            ShivirSectionItem::create(array_merge(['shivir_section_id' => $secOrganizers->id], $item));
        }

        // 4. Create Official Shivir Rules & Terms (23 Exact Points)
        $rules = [
            [
                'title' => 'पूर्ण गृह त्याग',
                'rule_text' => 'शिविर के दौरान सभी शिविरार्थी का पूर्णतः गृह त्याग रहेगा।',
                'rule_type' => 'mandatory',
                'sort_order' => 1,
            ],
            [
                'title' => 'आधार कार्ड एवं फोटो जमा करना',
                'rule_text' => 'शिविर के रजिस्ट्रेशन के लिए आधार कार्ड और दो फोटो संलग्न करना अनिवार्य है एवं शिविर की किट लेते समय आधार कार्ड की एक फोटोकॉपी जमा करवाना अनिवार्य है।',
                'rule_type' => 'mandatory',
                'sort_order' => 2,
            ],
            [
                'title' => 'केवल पंजीकृत पुरुष वर्ग हेतु',
                'rule_text' => 'शिविर में केवल पंजीकृत पुरुष वर्ग ही नियमित रूप से भाग ले सकते हैं।',
                'rule_type' => 'mandatory',
                'sort_order' => 3,
            ],
            [
                'title' => 'आयु सीमा एवं पात्रता नियम',
                'rule_text' => 'न्यूनतम 15 वर्ष से अधिकतम 60 वर्ष तक पूर्ण स्वस्थ व्यक्ति शिविर हेतु फॉर्म भर सकते हैं। 8 से 14 वर्ष तक के बालक भी शिविर मे भाग ले सकते हैं, अगर उनके कोई परिवारजन भी शिविर मे प्रवेश ले रहे हों तो।',
                'rule_type' => 'mandatory',
                'sort_order' => 4,
            ],
            [
                'title' => 'केश कर्तन (शेविंग एवं कटिंग)',
                'rule_text' => 'शिविर में प्रवेश के पूर्व शिवरार्थी को शेविंग व 2 नंबर trimmer द्वारा कटिंग करवाना अनिवार्य है।',
                'rule_type' => 'mandatory',
                'sort_order' => 5,
            ],
            [
                'title' => 'स्वास्थ्य एवं मेडिकल सर्टिफिकेट',
                'rule_text' => 'अस्वस्थ व जिनको गंभीर बीमारी हो वह व्यक्ति अपना मेडिकल सर्टिफिकेट लेकर आए एवं जिनकी दवाई आदि चलती है वह व्यक्ति शिविर संपर्क सूत्र पर चर्चा करके ही आवे।',
                'rule_type' => 'mandatory',
                'sort_order' => 6,
            ],
            [
                'title' => 'टोकन द्वारा किट प्राप्ति',
                'rule_text' => 'रजिस्ट्रेशन के बाद प्राप्त टोकन के माध्यम से ही शिविरार्थी अपनी किट ले सकते हैं।',
                'rule_type' => 'mandatory',
                'sort_order' => 7,
            ],
            [
                'title' => 'शिविरार्थी किट सामग्री विवरण',
                'rule_text' => 'शिविरार्थी की किट में शिविर से संबंधित पाठ्यक्रम की पुस्तक, कॉपी, पेन, आसन, अमृतधारा, बाम, धोती दुपट्टा इत्यादि सामान होगा।',
                'rule_type' => 'what_to_bring',
                'sort_order' => 8,
            ],
            [
                'title' => 'ध्यानस्थल आगमन अनुशासन',
                'rule_text' => 'सभी शिविरार्थियों को पंक्तिबद्ध होकर ही ध्यानस्थल तक आना होगा।',
                'rule_type' => 'mandatory',
                'sort_order' => 9,
            ],
            [
                'title' => 'वस्त्र एवं चप्पल त्याग',
                'rule_text' => 'शिविरार्थियों को धोती–दुपट्टा, अंतरंग वस्त्र, चटाई के अलावा अन्य सभी वस्त्रों एवं जूता चप्पल आदि का पूर्ण त्याग करना होगा।',
                'rule_type' => 'prohibition',
                'sort_order' => 10,
            ],
            [
                'title' => 'साबुन का प्रयोग निषेध',
                'rule_text' => 'शिविरार्थी को स्नान एवं वस्त्रों को साफ करने के लिए साबुन का प्रयोग नही करना है।',
                'rule_type' => 'prohibition',
                'sort_order' => 11,
            ],
            [
                'title' => 'व्यक्तिगत सामग्री',
                'rule_text' => 'शिविरार्थी को चादर, टावल इत्यादि अपने साथ लाना अनिवार्य है।',
                'rule_type' => 'what_to_bring',
                'sort_order' => 12,
            ],
            [
                'title' => 'शिविर अवधि में शेविंग-कटिंग निषेध',
                'rule_text' => 'शिविर के दौरान शिविरार्थी को शेविंग एवं कटिंग कराने की अनुमति नहीं होगी।',
                'rule_type' => 'prohibition',
                'sort_order' => 13,
            ],
            [
                'title' => 'मोबाइल फोन उपयोग पूर्णतः वर्जित',
                'rule_text' => 'शिविर में मोबाईल फोन का उपयोग पूर्णतः वर्जित है।',
                'rule_type' => 'prohibition',
                'sort_order' => 14,
            ],
            [
                'title' => 'बाह्य श्रावक-श्राविका उपस्थिति',
                'rule_text' => 'बाहर से आने वाले अतिरिक्त श्रावक श्राविकायें कक्षा एवं प्रवचन सभा आदि कार्यक्रमों में उपस्थित होकर धर्म लाभ ले सकते हैं।',
                'rule_type' => 'general',
                'sort_order' => 15,
            ],
            [
                'title' => 'पूजा स्थल आगमन नियम',
                'rule_text' => 'ध्यान के पश्चात सभी शिविरार्थियों को व्यवस्थित व अनुशासित ढंग से पंक्तिबद्ध होकर पूजा स्थल पर पहुंचना होगा।',
                'rule_type' => 'mandatory',
                'sort_order' => 16,
            ],
            [
                'title' => 'कक्षा पश्चात् आवास गमन',
                'rule_text' => 'कक्षा समाप्त होने के बाद सभी शिविरार्थी को पुनः आवास स्थल तक पहुंचना होगा।',
                'rule_type' => 'mandatory',
                'sort_order' => 17,
            ],
            [
                'title' => 'अमानती सामान बाहर ले जाने का नियम',
                'rule_text' => 'शिविर के दौरान अगर कोई शिविरार्थी शिविर स्थल से अमानती सामान लेकर बाहर जाना चाहता है तो दो व्यक्तियों के हस्ताक्षर अनिवार्य होंगे।',
                'rule_type' => 'mandatory',
                'sort_order' => 18,
            ],
            [
                'title' => 'आहार गमन एवं वापसी व्यवस्था',
                'rule_text' => 'आहार के लिए सभी शिविरार्थी को कार्यक्रम स्थल से, उपलब्ध बसों के द्वारा ही जाना होगा एवं आहार के पश्चात पुनः कार्यक्रम स्थल पर ही लौट कर आना होगा।',
                'rule_type' => 'mandatory',
                'sort_order' => 19,
            ],
            [
                'title' => 'भोजन एवं अल्पाहार नियम',
                'rule_text' => 'शिविरार्थी दिन में केवल एक बार भोजन के अतिरिक्त शाम को अल्पहार आदि ले सकते हैं।',
                'rule_type' => 'mandatory',
                'sort_order' => 20,
            ],
            [
                'title' => 'दैनिक चर्या एवं निर्देशों का पालन',
                'rule_text' => 'शिविर में निर्धारित नियमानुसार दैनिक चर्या एवं निर्देशों का पालन करना होगा।',
                'rule_type' => 'mandatory',
                'sort_order' => 21,
            ],
            [
                'title' => 'अनियमितता पर निष्कासन',
                'rule_text' => 'किसी भी प्रकार की अनियमितता पाये जाने पर शिविरार्थी को शिविर से निष्कासित किया जा सकता है।',
                'rule_type' => 'prohibition',
                'sort_order' => 22,
            ],
            [
                'title' => 'अनुशासन, शांति एवं एकता',
                'rule_text' => 'शिविर में अनुशासन, शांति एवं एकता बनाये रखना अनिवार्य है।',
                'rule_type' => 'mandatory',
                'sort_order' => 23,
            ],
        ];

        ShivirRule::where('shivir_id', $shivir2026->id)->delete();
        foreach ($rules as $r) {
            ShivirRule::create(array_merge(['shivir_id' => $shivir2026->id], $r));
        }

        // 5. Create Daily Schedule
        $schedules = [
            ['day_number' => 1, 'time_slot' => '05:00 AM - 06:00 AM', 'activity_name' => 'सामयिक एवं प्रात: प्रतिक्रमण', 'location_venue' => 'मुख्य प्रवचन मंडप'],
            ['day_number' => 1, 'time_slot' => '06:00 AM - 07:30 AM', 'activity_name' => 'जिनेन्द्र अभिषेक एवं पूजन (धोती-दुपट्टा अनिवार्य)', 'location_venue' => 'मुख्य मंदिर जी'],
            ['day_number' => 1, 'time_slot' => '08:00 AM - 09:00 AM', 'activity_name' => 'प्रातः प्रासुक जलपान (अल्पाहार)', 'location_venue' => 'भोजन शाला'],
            ['day_number' => 1, 'time_slot' => '09:30 AM - 11:30 AM', 'activity_name' => 'परम पूज्य मुनिश्री का मंगल प्रवचन एवं तत्व चर्चा', 'location_venue' => 'मुख्य प्रवचन हॉल'],
            ['day_number' => 1, 'time_slot' => '11:30 AM - 01:00 PM', 'activity_name' => 'मुनिश्री की आहार चर्या एवं मध्याह्न विश्राम', 'location_venue' => 'आहार स्थल'],
            ['day_number' => 1, 'time_slot' => '02:00 PM - 04:00 PM', 'activity_name' => 'तत्त्वार्थ सूत्र कक्षा एवं धार्मिक स्वाध्याय', 'location_venue' => 'कक्षा कक्ष - ब्लॉक ए'],
            ['day_number' => 1, 'time_slot' => '05:30 PM - 06:30 PM', 'activity_name' => 'सायंकालीन प्रतिक्रमण एवं शंका समाधान', 'location_venue' => 'मुख्य पांडाल'],
            ['day_number' => 1, 'time_slot' => '07:00 PM - 08:30 PM', 'activity_name' => 'जिनेन्द्र महाआरती एवं सांस्कृतिक कार्यक्रम', 'location_venue' => 'मुख्य रंगमंच'],
        ];

        foreach ($schedules as $index => $s) {
            ShivirSchedule::create(array_merge([
                'shivir_id' => $shivir2026->id,
                'sort_order' => $index + 1,
            ], $s));
        }

        // 6. Create FAQs
        $faqs = [
            [
                'question' => 'क्या पंजीयन शुल्क देय है?',
                'answer' => 'नहीं, संस्कार शिविर पूर्णतः निःशुल्क है। आवास एवं भोजन व्यवस्था आयोजक समिति द्वारा की जाती है।',
                'sort_order' => 1,
            ],
            [
                'question' => 'पंजीयन के बाद प्रवेश पत्र कैसे मिलेगा?',
                'answer' => 'पंजीयन फॉर्म जमा करने के पश्चात स्क्रीन पर क्यूआर कोड (QR Code) युक्त पंजीयन पर्ची दिखाई देगी। इसे तुरंत डाउनलोड/प्रिंट करें या "पंजीयन देखें" विकल्प से बाद में भी निकाल सकते हैं।',
                'sort_order' => 2,
            ],
            [
                'question' => 'कमरा / आवास आवंटन कब और कैसे होगा?',
                'answer' => 'कमरा आवंटन ऑनलाइन नहीं होता है। जब आप शिविर स्थल अशोकनगर पहुंचेंगे, तब काउंटर पर अपनी पंजीयन पर्ची या क्यूआर कोड दिखाकर कमरे का आवंटन प्राप्त करेंगे।',
                'sort_order' => 3,
            ],
            [
                'question' => 'क्या शिविर में मोबाइल रखना सख्त मना है?',
                'answer' => 'हाँ, पूज्य गुरुदेव के निर्देशानुसार शिविरार्थियों का ध्यान साधना में रहे, इसलिए 10 दिनों तक मोबाइल रखना निषेध है। आपातकालीन संपर्क हेतु समिति का हेल्पलाइन नंबर परिजनों को दिया जा सकता है।',
                'sort_order' => 4,
            ],
        ];

        foreach ($faqs as $f) {
            ShivirFaq::create(array_merge(['shivir_id' => $shivir2026->id], $f));
        }

        // 7. Create Announcements
        Announcement::create([
            'shivir_id' => $shivir2026->id,
            'title' => 'पंजीयन तिथि अंतिम सूचना!',
            'description' => '33वें श्रावक संस्कार शिविर अशोकनगर हेतु ऑनलाइन पंजीयन प्रारंभ हैं। सीमित सीटों के कारण शीघ्र पंजीयन कराएं।',
            'priority' => 'important',
            'start_date' => now(),
            'end_date' => now()->addDays(15),
        ]);

        // 8. Create Accommodation Blocks, Rooms, Beds
        $blockA = AccommodationBlock::create([
            'shivir_id' => $shivir2026->id,
            'name' => 'ब्लॉक ए (ऋषभ देव भवन)',
            'description' => 'मुख्य मंदिर जी के निकट स्थित प्रथम आवास परिसर।',
        ]);

        $blockB = AccommodationBlock::create([
            'shivir_id' => $shivir2026->id,
            'name' => 'ब्लॉक बी (महावीर स्वामी भवन)',
            'description' => 'प्रवचन मंडप के सामने स्थित द्वितीय आवास परिसर।',
        ]);

        $bedsPool = [];
        foreach ([$blockA, $blockB] as $block) {
            for ($r = 101; $r <= 104; $r++) {
                $room = AccommodationRoom::create([
                    'accommodation_block_id' => $block->id,
                    'room_number' => (string)$r,
                    'capacity' => 4,
                    'floor' => 'प्रथम तल',
                ]);
                for ($b = 1; $b <= 4; $b++) {
                    $bed = AccommodationBed::create([
                        'accommodation_room_id' => $room->id,
                        'bed_number' => "Bed-{$b}",
                        'is_occupied' => false,
                    ]);
                    $bedsPool[] = $bed;
                }
            }
        }

        // 9. Create Groups
        $group1 = Group::create([
            'shivir_id' => $shivir2026->id,
            'name' => 'साधना समूह – 01',
            'leader_name' => 'श्री अमित जैन (गुना)',
            'leader_contact' => '9826011111',
            'meeting_point' => 'हॉल नं. 1, ऋषभ भवन',
        ]);

        $group2 = Group::create([
            'shivir_id' => $shivir2026->id,
            'name' => 'स्वाध्याय समूह – 02',
            'leader_name' => 'श्री विकास जैन (इंदौर)',
            'leader_contact' => '9826022222',
            'meeting_point' => 'हॉल नं. 3, महावीर भवन',
        ]);

        // 10. Create Attendance Sessions
        $sessionMorning = AttendanceSession::create([
            'shivir_id' => $shivir2026->id,
            'session_name' => 'प्रातः प्रतिक्रमण एवं पूजन (दिवस 1)',
            'session_date' => '2026-08-25',
            'type' => 'morning',
            'is_active' => true,
        ]);

        $sessionPravachan = AttendanceSession::create([
            'shivir_id' => $shivir2026->id,
            'session_name' => 'मुख्य तत्वज्ञान प्रवचन (दिवस 1)',
            'session_date' => '2026-08-25',
            'type' => 'session',
            'is_active' => true,
        ]);

        // 11. Create 20 Realistic Participants & Registrations
        $cities = [
            ['city' => 'अशोकनगर', 'district' => 'अशोकनगर', 'state' => 'मध्य प्रदेश', 'pincode' => '473331'],
            ['city' => 'गुना', 'district' => 'गुना', 'state' => 'मध्य प्रदेश', 'pincode' => '473001'],
            ['city' => 'इंदौर', 'district' => 'इंदौर', 'state' => 'मध्य प्रदेश', 'pincode' => '452001'],
            ['city' => 'भोपाल', 'district' => 'भोपाल', 'state' => 'मध्य प्रदेश', 'pincode' => '462001'],
            ['city' => 'सागर', 'district' => 'सागर', 'state' => 'मध्य प्रदेश', 'pincode' => '470001'],
            ['city' => 'ललितपुर', 'district' => 'ललितपुर', 'state' => 'उत्तर प्रदेश', 'pincode' => '284403'],
            ['city' => 'झांसी', 'district' => 'झांसी', 'state' => 'उत्तर प्रदेश', 'pincode' => '284001'],
            ['city' => 'जयपुर', 'district' => 'जयपुर', 'state' => 'राजस्थान', 'pincode' => '302001'],
        ];

        $firstNames = ['अरविन्द', 'संजय', 'दीपक', 'राजेश', 'विवेक', 'सचिन', 'प्रदीपक', 'प्रशांत', 'सुनील', 'विकास', 'निलेश', 'आलोक', 'सतीश', 'सुमित', 'पंकज', 'महेश', 'अनिल', 'विशाल', 'नवीन', 'आशीष'];
        $fatherNames = ['श्री हुकमचंद', 'श्री प्रकाशचंद', 'श्री कैलाशचंद', 'श्री मूलचंद', 'श्री प्रेमचंद', 'श्री कपूरचंद', 'श्री रतनलाल', 'श्री शांतिलाल', 'श्री ज्ञानचंद', 'श्री नेमचंद'];

        for ($i = 1; $i <= 20; $i++) {
            $fn = $firstNames[$i - 1];
            $father = $fatherNames[array_rand($fatherNames)];
            $loc = $cities[array_rand($cities)];
            $age = rand(21, 65);
            $dob = now()->subYears($age)->subDays(rand(1, 300))->format('Y-m-d');
            $mobile = '9826' . str_pad($i, 6, '0', STR_PAD_LEFT);
            $regNo = sprintf('ASH-2026-%05d', $i + rand(1000, 99999));
            $qrToken = Str::random(40);

            $participant = Participant::create([
                'full_name' => "{$fn} जैन",
                'father_name' => "{$father} जैन",
                'mother_name' => 'श्रीमती सुशीला देवी जैन',
                'dob' => $dob,
                'age' => $age,
                'mobile' => $mobile,
                'whatsapp' => $mobile,
                'email' => "participant{$i}@example.com",
                'address' => "मकान नं. {$i}0, जैन मंदिर रोड, {$loc['city']}",
                'city' => $loc['city'],
                'district' => $loc['district'],
                'state' => $loc['state'],
                'pincode' => $loc['pincode'],
                'education' => 'बी.कॉम / स्नातक',
                'occupation' => 'व्यापार (व्यवसाय)',
                'family_info' => 'संयुक्त परिवार',
                'social_org' => 'सकल दिगंबर जैन समाज',
                'social_position' => 'सदस्य',
                'previous_shivir_attended' => ($i % 2 === 0),
                'previous_shivir_count' => ($i % 2 === 0) ? rand(1, 4) : 0,
                'emergency_contact_name' => "{$father} जैन",
                'emergency_contact_number' => '94250' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'blood_group' => ['B+', 'O+', 'A+', 'AB+'][rand(0, 3)],
            ]);

            $status = ($i <= 15) ? 'approved' : 'pending';
            if ($i <= 10) {
                $status = 'checked_in';
            }

            $registration = Registration::create([
                'shivir_id' => $shivir2026->id,
                'participant_id' => $participant->id,
                'registration_number' => $regNo,
                'qr_token' => $qrToken,
                'status' => $status,
                'rules_accepted' => true,
                'checked_in_at' => ($status === 'checked_in') ? now()->subHours(rand(1, 12)) : null,
                'checked_in_by' => ($status === 'checked_in') ? 1 : null,
            ]);

            // Allocate room for first 8 checked-in participants
            if ($i <= 8 && isset($bedsPool[$i - 1])) {
                $bed = $bedsPool[$i - 1];
                $bed->update(['is_occupied' => true]);

                RoomAllocation::create([
                    'registration_id' => $registration->id,
                    'accommodation_bed_id' => $bed->id,
                    'allocated_at' => now()->subHours(rand(1, 6)),
                    'allocated_by' => 1,
                    'notes' => 'स्थल पर चेक-इन के समय आवंटित',
                ]);
            }

            // Assign group
            if ($i % 2 === 0) {
                GroupMember::create(['group_id' => $group1->id, 'registration_id' => $registration->id]);
            } else {
                GroupMember::create(['group_id' => $group2->id, 'registration_id' => $registration->id]);
            }

            // Attendance records
            if ($status === 'checked_in' && $i <= 6) {
                AttendanceRecord::create([
                    'attendance_session_id' => $sessionMorning->id,
                    'registration_id' => $registration->id,
                    'scanned_at' => now()->subHours(rand(2, 5)),
                    'scanned_by' => 1,
                    'device_info' => 'Android Staff Scanner App',
                ]);
            }
        }
    }
}
