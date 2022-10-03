<?php

return [
    'job' => [
        'name'=>[
        'requierd' => 'إسم الطلب مطلوب',
        'max' => 'إسم الطلب لايزيد عن 100 حرف',
        'regex' => 'لا يمكن إضافه العلامات الخاصه',
        ] ,
        'customer'=>[
            'requierd' => 'إسم العميل مطلوب',
        ],
        'order_types'=>[
            'in' => '  الرجاء اختيار نوع العقد بطريقه صحيحة',
        ]
    ],
    'order' => [
        'customer' => [
            'required' => 'رقم العميل مطلوب',
        ],
        'order_types' => [
            'in' => '(complaint,proof_death,proof_insolvency) نوع الطلب يجب يكون اى من الآتى '
        ],
        'customer_type' => [
            'in' => '(mobile,identity) نوع العميل يجب يكون اى من الآتى '
        ],
        'order_subject' => [
            'required' => 'موضوع الطلب مطلوب'
        ],
        'order_subject' => [
            'max' => 'موضوع الطلب لا يكون اكبر من 100 حرف'
        ]
    ]

];
