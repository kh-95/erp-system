<?php

return [
    'accountingtree'=>[
        'revise_no'=>[
            'required'=>'.حقل الرقم المرجعى مطلوب',
            'unique'=>'حقل الرقم المرجعى مكرر'
        ],
        'account_type'=>[
            'required'=>'.حقل نوع الحساب مطلوب',
        ],
        'account_name'=>[
            'required'=>'.حقل اسم الحساب مطلوب',
        ],
        'account_code'=>[
            'required'=>'حقل الرمز مطلوب',
            'max'=>'يجب الرمز لا يزيد عن 10 ارقام',
            'numeric'=>'يجب الرمز ان يكون أرقام فقط',
            'unique'=>'حقل رقم الحساب مكرر'
        ],
        'parent_id'=>[
            'required'=>'.حقل الحساب الرئيسى مطلوب',
        ],
        'child_id'=>[
            'required'=>'.حقل الحساب الفرعى مطلوب',
        ],
    ],
    'assetcategory'=>[
        'revise_no'=>[
            'required'=>'.حقل الرقم المرجعى مطلوب',
            'unique'=>'حقل الرقم المرجعى مكرر'
        ],
        'account_tree_id'=>[
            'required'=>'.حقل الحساب مطلوب',
        ],
        'destroy_ratio'=>[
            'required'=>'.حقل نسبة الاهلاك مطلوب',
        ],
        'name'=>[
            'required'=>'حقل الاسم مطلوب',
        ],
    ],
];
