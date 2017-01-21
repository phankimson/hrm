<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->integer('period_id');
            $table->integer('employee_id');
           $table->string('wage_day');
                $table->string('workday');
                $table->string('nightshift');
                $table->string('holiday_work');
                $table->string('holiday_overtime');
                $table->string('off_overtime');
                $table->string('overtime');
                $table->string('work_clear');
                $table->string('arrive_leave');
                $table->string('telephone_allowance');
                $table->string('petrol_allowance');
                $table->string('shift_meal_allowance');
                $table->string('orther_allowance');
                $table->string('on_leave_pay');
                $table->string('personal_deductions');
                $table->string('family_allowances');
                $table->string('advance');
                $table->string('personal_income_tax');
                $table->string('social_insurance');
                $table->string('health_insurance');
                $table->string('unemployment_insurance');
                $table->string('service_charge');
                $table->string('bonus_sales');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
