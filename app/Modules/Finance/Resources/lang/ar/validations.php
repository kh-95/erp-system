<?php

return [
    'notification' => [
       'type' => [
        'required' => 'حقل نوع الإشعار مطلوب',
        'in' => 'adding, equation, discount حق نوع الإشعار يجب ان يكون '
       ],
       'way' => [
        'required' => 'حقل طريقة الإشعار مطلوب',
        'in' => 'customer, customerWithService حق طريقة الإشعار يجب ان يكون '
       ],
       'notification_number' => [
        'required' => 'حقل رقم الإشعار مطلوب'
       ],
       'date' => [
        'required' => 'حقل تاريخ الإشعار مطلوب'
       ],
       'management_id' => [
        'required' => 'حقل رقم الإدارة الإشعار مطلوب'
       ],
       'notification_name' => [
        'required' => 'حقل إسم الإشعار مطلوب'
       ],
       'price' => [
        'required' => 'حقل المبلغ الإشعار مطلوب'
       ],
       'complaint_number' => [
        'required' => 'حقل رقم الشكوى الإشعار مطلوب'
       ],
       'customer_id' => [
        'required' => 'حقل العميل الإشعار مطلوب'
       ],
       'attachments' => [
        'required' => 'حقل المرفقات مطلوب'
       ]

       ],
       'cashRegister' => [
          'tranfer_number' => [
            'required' => 'حقل رقم التحويل مطلوب'
          ],
          'money' => [
            'required' => 'حقل المبلغ مطلوب'
          ],
          'date' => [
            'required' => 'حقل التاريخ مطلوب'
          ],
          'from_register' => [
            'required' => 'حقل الخزنة المرسلة مطلوب'
          ],
          'from_register' => [
            'required' => 'حقل الخزنة المستقبلة مطلوب'
          ],
          'bank_id' => [
            'required' => 'حقل البنك مطلوب'
          ],
          'check_number' => [
            'required' => 'حقل رقم الشييك مطلوب'
          ],
          'check_number_date' => [
            'required' => 'حقل تاريخ رقم الشييك مطلوب'
          ],
          'attachments' => [
            'required' => 'حقل المرفقات مطلوب'
          ]

       ]

];
