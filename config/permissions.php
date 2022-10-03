<?php

return [
    /**
     * 'lowerModelName' =>
     * [
     * 'slug' => 'name_ar',
     * 'extraPermissions' => ['extraPermission1' => 'name_ar1', 'extraPermission2' => 'name_ar2'], // if you don't need extra permissions you can unset key
     * 'exceptPermissions' => ['delete'], // from ['list', 'create', 'edit', 'delete' ,'show'] if you don't need except permissions you can unset key
     * ]
     **/

    'role' => [
        'slug' => 'الادوار',
        'module' => 'user',
    ],
    'permission' => [
        'slug' => 'الصلاحيات',
        'module' => 'user',
    ],
    'nationality' => [
        'slug' => 'الجنسيات',
        'module' => 'hr',
        'extraPermissions' => ['archive' => 'أرشيف']
    ],
    'salary' => [
        'slug' => 'الرواتب',
        'module' => 'hr',
        'extraPermissions' => ['changeSalaryStatus' => 'توقيع الرواتب', 'getSalaryStatus' => 'سجل الرواتب بدون توقيع']

    ],
    'user' => [
        'slug' => 'المستخدمين',
        'module' => 'user',
    ],
    'visit' => [
        'slug' => 'الزوار',
        'module' => 'reception',
    ],
    'employee' => [
        'slug' => 'الموظفين',
        'module' => 'hr',
        'exceptPermissions' => ['delete']
    ],
    'management' => [
        'slug' => 'الأدارات',
        'module' => 'hr',
        'extraPermissions' => ['archive' => 'أرشيف'],
        'exceptPermissions' => ['forExternalServices']
    ],
    'hr_service_request' => [
        'slug' => 'طلبات الخدمة',
        'module' => 'hr',
        'exceptPermissions' => ['delete']
    ],
    'hr_job' => [
        'slug' => 'الوظائف',
        'module' => 'hr',
        'extraPermissions' => ['archive' => 'أرشيف'],
        'exceptPermissions' => ['forExternalServices']
    ],
    'blacklist' => [
        'slug' => 'القائمة السوداء',
        'module' => 'hr',
    ],
    'deducts'=>[
        'slug' =>'الخصومات',
        'module'=>'hr'
    ],
    'ponuses'=>[
        'slug' =>'المكافئات',
        'module'=>'hr',
        'extraPermissions' => ['bonusStatus' => 'حالة '],

    ],
    'hr_item' => [
        'slug' => 'البنود',
        'module' => 'hr',
    ],
    'reception-report' => [
        'slug' => 'البلاغات',
        'module' => 'reception',
        'extraPermissions' => ['archive' => 'أرشيف', 'restore' => 'إسترجاع'],
    ],
    'appointment' => [
        'slug' => 'المواعيد',
        'module' => 'secretariat',
        'extraPermissions' => ['archive' => 'أرشيف']
    ],
    'meetingRoom' => [
        'slug' => 'غرف الاجتماعات',
        'module' => 'secretariat',
    ],
    'meeting' => [
        'slug' => 'الاجتماعات',
        'module' => 'secretariat',
    ],
    'vacationtype' => [
        'slug' => 'أنواع الاجازات',
        'module' => 'hr',
        'extraPermissions' => ['archive' => 'أرشيف']
    ],

    'vacation' => [
        'slug' => ' الاجازات',
        'module' => 'vacation'
    ],

    'attendance_fingerprints' => [
        'slug' => ' السحضور و الانصراف',
        'module' => 'hr',
        'exceptPermissions' => ['forExternalServices', 'edit', 'delete'],
        'extraPermissions' => ['updateAttend' => 'انصراف', 'listFingerprint' => 'سجل البضمات']
    ],
    'permission_requests' => [
        'slug' => 'الأذونات',
        'module' => 'hr',
        'exceptPermissions' => ['forExternalServices', 'edit'],
        'extraPermissions' => ['updateStatusByManager' => 'انصراف', 'updateStatusByHr' => 'سجل البضمات', 'archive' => 'أرشيف']
    ],
    'resignation' => [
        'slug' => 'طلبات الأستقالة',
        'module' => 'hr',
    ],
    'employee_evaluation' => [
        'slug' => ' تقييم الموظفين',
        'module' => 'hr',
    ],

    'investigations' => [
        'slug' => 'التحقيقات',
        'module' => 'legal',
    ],
    'agenecies' => [
        'slug' => 'الوكالات',
        'module' => 'legal',
        'exceptPermissions' => ['forExternalServices', 'edit'],
    ],
    'agenecy_types' => [
        'slug' => 'أنواع الوكالات',
        'module' => 'legal',
        'exceptPermissions' => ['forExternalServices', 'edit'],
    ],
    'agenecy_terms' => [
        'slug' => 'بنود الوكالات',
        'module' => 'legal',
        'exceptPermissions' => ['forExternalServices', 'edit'],
    ],
    'static_text' => [
        'slug' => 'النصوص الثابتة',
        'module' => 'legal',
        'exceptPermissions' => ['forExternalServices', 'edit'],
    ],
    'training_course' => [
        'slug' => 'الدورات التدريبيه',
        'module' => 'hr',
    ],
    'draft' => [
        'slug' => 'طلبات الصياغة',
        'module' => 'legal',
    ],
    'consult' => [
        'slug' => 'طلبات الاستشارة',
        'module' => 'legal',
    ],
    'harmless_hold' => [
        'slug' => 'إخلاء طرف',
        'module' => 'hr',
        'extraPermissions' => [
            'dm_store' => 'تسجيل  المدير المباشر',
            'finance_store' => 'تسجيل الشئون المالية',
            'hr_store' => 'تجسيل الموارد البشرية',
            'it_store' => 'تسجيل تقنية المعلومات',
         'legal_store' => 'تسجيل الشئون القانونية',
            'archive' => 'أرشيف',
           'restore' => 'إسترجاع'
        ],
    ],
    'candidacy_application' => [
        'slug' => 'طلبات الترشح',
        'module' => 'Governance',
    ],
    'members' => [
        'slug' => 'أعضاء مجلس الإدارة',
        'module' => 'governance',
    ],
    'strategic-plans'=> [
         'slug' =>'الخطط الاستراتيجية' ,
         'module' => 'governance'
    ],
    'governance_notifications' => [
        'slug' => 'تنبيهات ضوابط الإشراف',
        'module' => 'governance',
    ],
    'meeting_places' => [
        'slug' => 'اماكن الاجتماع',
        'module' => 'governance',
        'exceptPermissions' => ['forExternalServices', 'edit'],
    ],
    'committee' => [
        'slug' => 'اللجان ',
        'module' => 'governance',
        'exceptPermissions' => ['forExternalServices', 'edit'],
    ],
    'requlations' => [
        'slug' => ' اللوائح والسياسات',
        'module' => 'governance',
        ],
    'calls' => [
        'slug' => 'المكالمات',
        'module' => 'CustomerService',
        'exceptPermissions' => ['forExternalServices', 'edit', 'create', 'edit', 'delete', 'show'],
        'extraPermissions'  => ['convertCall']
    ],
    'asset' => [
        'slug' => 'الأصول المالية',
        'module' => 'Finance',
    ],
    'transactions' => [
        'slug' => 'المعاملات',
        'module' => 'RiskManagement',
        'exceptPermissions' => ['edit', 'create', 'delete', 'store', 'update'],
    ],
    'vendors' => [
        'slug' => 'العملاء',
        'module' => 'RiskManagement',
        'exceptPermissions' => ['edit', 'create', 'delete', 'store', 'update'],
    ],
    'rm_notifications' => [
        'slug' => 'تنبيهات و إشعارات إدارة المخاطر',
        'module' => 'RiskManagement',
        'exceptPermissions' => ['forExternalServices'],
    ],

    'fi_notifications' => [
        'slug' => 'إشعارات إدارة الماليه',
        'module' => 'Finance',
        'extraPermissions' => [
         'removeAttachment' => 'حذف ملف']
    ],
    'fi_cashRegister' => [
        'slug' => 'خزنة',
        'module' => 'Finance',
        'extraPermissions' => [
        'removeAttachment' => 'حذف ملف']
    ],
    'fi_expenses' => [
        'slug' => 'خزنة',
        'module' => 'Finance',
        'extraPermissions' => [
        'removeAttachment' => 'حذف ملف']
    ],
    'fi_receipt' => [
        'slug' => 'خزنة',
        'module' => 'Finance',
        'extraPermissions' => [
        'removeAttachment' => 'حذف ملف']
    ],

    'customer_service_employees' => [
        'slug' => 'موظفين خدمة العملاء',
        'module' => 'CustomerService',
    ],
    'banks' => [
        'slug' => 'البنوك',
        'module' => 'RiskManagement',
        'extraPermissions'  => ['listBanks' => 'سجل البنوك']

    ],
    'vendor_class' => [

        'slug' => 'فئة العملاء',
        'module' => 'RiskManagement'

    ],
    'accountingtree' => [
        'slug' => 'إعدادات شجرة الحسابات',
        'module' => 'finance',
        'extraPermissions'  => ['moveaccount' => 'نقل الحساب']
    ],

    'fi_notifications' => [
        'slug' => 'إشعارات إدارة الماليه',
        'module' => 'Finance',
        'extraPermissions' => [
            'removeAttachment' => 'حذف ملف'
        ],
    ],
    'rm_vendor_notifications' => [
        'slug' => 'التنبيهات و الاشعارات إدارة المخاطر',
        'module' => 'RiskManagement',
        'exceptPermissions' => ['forExternalServices', 'edit'],
        'extraPermissions' => [
            'takeAction' => 'اتخاذ اجراء'
        ],

    ],
    'company_cases' => [
        'slug' => 'قضايا الشركة',
        'module' => 'Legal',
        'extraPermissions' => [
            'removeAttachment' => 'حذف ملف'
        ],

    ],
    'assetcategory' => [
        'slug' => 'إعدادت تصنيفات الاصول',
        'module' => 'finance',
    ],
    'custody' => [
        'slug' => 'العهدة',
        'module' => 'finance',
    ],
    'constrainttype' => [
        'slug' => 'إعدادات أنواع القيود',
        'module' => 'finance',
    ],
    'expensetype' => [
        'slug' => 'إعدادات أنواع المصروف',
        'module' => 'finance',
    ],
    'receipttype' => [
        'slug' => 'إعدادات أنواع المقبوضات',
        'module' => 'finance',
    ],
    'notificationname' => [
        'slug' => 'مسميات الاشعارات',
        'module' => 'finance',

    ], 'collection_order' => [
        'slug' => 'الطلبات ',
        'module' => 'collection',
        'extraPermissions' => [
            'remove_attachment' => 'حذف ملف',
        ],
    ],
    'contract_clause' => [
        'slug' => 'بنود العقد',
        'module' => 'HR',
    ],
    'installments' => [
        'slug' => ' الأقساط',
        'module' => 'Collection',
    ],

    'messages' => [
        'slug' => 'إخلاء طرف',
        'module' => 'Secretariat',
        'extraPermissions' => [
            'archive' => 'أرشيف',
           'restore' => 'إسترجاع'
        ],
    ],
    'operation'=>[
        'slug' => 'العمليات ',
        'module' => 'Collection',
    ],

    'collection_rasid_maeak' => [
        'slug' => 'رصيد معاك تحصيل ',
        'module' => 'collection',
    ],

];
