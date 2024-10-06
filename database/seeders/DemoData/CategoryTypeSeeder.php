<?php

namespace Database\Seeders\DemoData;

use App\Models\CategoryType;
use Illuminate\Database\Seeder;

class CategoryTypeSeeder extends Seeder
{
    public function run()
    {
        //Category Type-1
        $category_type = ['name'=>'Medical Equipments','unique_key'=>'ME','entry_type'=>"1", 'operator_id'=> '1'];
        CategoryType::create($category_type);

        //Category Type-2
        $category_type1 = ['name'=>'PPE','unique_key'=>'PPE','entry_type'=>"0", 'operator_id'=> '1'];
        CategoryType::create($category_type1);

        //Category Type-3
        $category_type2 = ['name'=>'OPPS','unique_key'=>'OPPS','entry_type'=>"1", 'operator_id'=> '1'];
        CategoryType::create($category_type2);

        //Category Type-4
        $category_type3 = ['name'=>'Information Technology','unique_key'=>'IT','entry_type'=>"1", 'operator_id'=> '1'];
        CategoryType::create($category_type3);
    }
}
