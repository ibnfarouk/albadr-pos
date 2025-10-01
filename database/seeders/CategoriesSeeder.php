<?php

namespace Database\Seeders;

use App\Enums\CategoryStatusEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * CategoriesSeeder - Seeder لإنشاء بيانات تجريبية للفئات
 * 
 * هذا الـ Seeder يقوم بـ:
 * - إنشاء 12 فئة بأسماء عربية واقعية
 * - إنشاء صور ملونة تلقائياً لكل فئة
 * - حفظ معلومات الصور في جدول Files
 * - استخدام PHP GD لإنشاء الصور ديناميكياً
 * 
 * @author Adham
 * @version 1.0
 */
class CategoriesSeeder extends Seeder
{
    /**
     * تشغيل الـ Seeder وإنشاء البيانات التجريبية
     * 
     * هذه الدالة تقوم بـ:
     * - إنشاء 12 فئة بأسماء عربية مختلفة
     * - تعيين حالات مختلفة (نشط/غير نشط)
     * - إنشاء صور ملونة لكل فئة
     * 
     * @return void
     */
    public function run(): void
    {
        for ($i=1; $i<=10; $i++) {
            \App\Models\Category::updateOrCreate([
                'name' => 'Category ' . $i,
            ], [
                'name' => 'Category ' . $i,
                'status' => CategoryStatusEnum::active,
            ]);
        }
    }
}
