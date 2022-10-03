<?php

return [
    'appointment'=>[
        'employee_id'=>[
            'required'=>'.حقل صاحب الموعد مطلوب',
        ],
        'appointment_date'=>[
            'required'=>'حقل التاريخ مطلوب',
            'date'=>'صيغة التاريخ غير صحيحة',
        ],
        'appointment_time'=>[
            'required'=>'حقل الوقت مطلوب',
            'date_equals'=>'صيغة الوقت غير صحيحة',
        ],
        'appointment_am'=>[
            'required'=>'.حقل مطلوب',
        ],
        'title'=>[
            'required'=>'حقل سبب الموعد مطلوب',
            'max'=>'يجب ان يكون حقل سبب الموعد لا يزيد عن 150 حرف',
            'string'=>'يجب ان يكون حقل سبب الموعد نص'
        ],
    ],

];
