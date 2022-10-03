<?php
/*

*/

namespace App\Modules\HR\Tests\Unit\Employee;

use App\Modules\HR\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Nationality;
use App\Modules\HR\Entities\Job;
use App\Modules\HR\Entities\Allowance;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Providers\RouteServiceProvider;

use Carbon\Carbon;
class EmpCrudTest extends TestCase
{
     use WithFaker, RefreshDatabase;
     private $baseUrl = RouteServiceProvider::ROUTE_PREFIX . '/employees/';

    public function test_create_employee()
    {
        $employeeData = $this->createEmployeeData(); //generate Employee Data
        $response     = $this->actingAsWithPermission('create-employee')->postJson($this->baseUrl, $employeeData);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'data',
            ]);
    }


    public function test_invalid_employee_data(){
        $employeeData = $this->createEmployeeWithDataRequired(); //generate Employee Data
        $response     = $this->actingAsWithPermission('create-employee')->postJson($this->baseUrl, $employeeData);
        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'exception',
            ]);
    }

    private function getNationality(){
        $nationality = Nationality::latest()->first();
        return $nationality->id;
    }

    private function generateEmployeeNumber(){
        $emp = new Employee();
        return $emp->generateEmployeeNumber();
    }

    //Create new Allownces and generate his data
    private function createAllownces(){
        $allowances   = array();
        $allowances[] = ['allowance_id'=>Allowance::factory()->create()->id,'status'=>false];
        $allowances[] = ['allowance_id'=>Allowance::factory()->create()->id,'status'=>false];
        return $allowances;
    }

    //Create new Allownces and generate his data
    private function getAllowncesToUpdate(){
        $allowances   = array();
        $allow        = Allowance::first();
        $allowances[] = ['allowance_id'=>$allow->id,'status'=>false];
        $allow        = Allowance::orderBy('id','desc')->first();
        $allowances[] = ['allowance_id'=>$allow->id,'status'=>false];
        return $allowances;
    }

    // Create Custodies Data
    private function createCustodiesData($delivery_date,$received_date,$count){

        $custodies = [['type'=>'labtop','received_date'=>$received_date,
                       'delivery_date'=>$delivery_date,'count'=>1]
                     ,['type'=>'lab','received_date'=>$received_date,
                       'delivery_date'=>$delivery_date,'count'=>1]
                     ,['type'=>'computer','received_date'=>$received_date,
                       'delivery_date'=>$delivery_date,'count'=>1]
                     ,['type'=>'server','received_date'=>$received_date,
                       'delivery_date'=>$delivery_date,'count'=>1]];
        return $custodies;
    }

    //Generate identity_photo and qualification_photo
    private function createAttachmentsImages($identity_photo,$qualification_photo){
      return $attachments = ['identity_photo'=>$identity_photo,'qualification_photo'=>$qualification_photo];
    }

    //Generate Employee Data To Create
    private function createEmployeeWithDataRequired(){
        $emp_number = $this->generateEmployeeNumber();
        $image = UploadedFile::fake()->image('avatar.jpg'); //upload fake image file
        $identity_source = "document.pdf";
        $deactivated_at  = $delivery_date = $received_date = Carbon::now();
        $attachments     = $this->createAttachmentsImages($image,$image);
        $custodies       = $this->createCustodiesData($delivery_date,$received_date,1);
        //generate Employee data
        return [
            'image'=>$image,
            'identification_number'=>$this->faker->numerify('##########'),
            'nationality_id'=>Nationality::factory()->create()->id,
            'first_name'=>'ahmed',
            'second_name'=>'mohamed',
            'third_name'=>'ali',
            'last_name'=>'ahmed',
            'phone'=>$this->faker->numerify('##########'),
            'identity_date'=>$this->faker->date(),
            'identity_source'=>$identity_source,
            'employee_number'=>$emp_number,
            'date_of_birth'=>$this->faker->date(),
            'marital_status'=>'single',
            'email'=>$this->faker->email(),
            'gender'=>'male',
            'qualification'=>'Computer Science',
            'address'=>'Embaba',

            'custodies'=>$custodies,
            'allowances'=>$this->createAllownces(),
            'job_id'=>'',
            'receiving_work_date'=>$this->faker->date(),
            'contract_period'=>1,
            'contract_type'=>'salary',
            'salary'=>1000.00,
            ];
    }

    //Generate Employee Data
    private function createEmployeeData(){
        $image = UploadedFile::fake()->image('avatar.jpg'); //upload fake image file
        $identity_source = "document.pdf";
        $deactivated_at  = $delivery_date = $received_date = Carbon::now();
        $attachments     = $this->createAttachmentsImages($image,$image);
        $custodies       = $this->createCustodiesData($delivery_date,$received_date,1);
        //generate Employee data
        return [
            'image'=>$image,
            'identification_number'=>$this->faker->numerify('##########'),
            'nationality_id'=>Nationality::factory()->create()->id,
            'first_name'=>'ahmed',
            'second_name'=>'mohamed',
            'third_name'=>'ali',
            'last_name'=>'ahmed',
            'phone'=>$this->faker->numerify('##########'),
            'identity_date'=>$this->faker->date(),
            'identity_source'=>$identity_source,
            'employee_number'=>'456522',
            'date_of_birth'=>$this->faker->date(),
            'marital_status'=>'single',
            'email'=>$this->faker->email(),
            'gender'=>'male',
            'qualification'=>'Computer Science',
            'address'=>'Embaba',

            'attachments'=>$attachments,
            'custodies'=>$custodies,
            'allowances'=>$this->createAllownces(),
            'job_id'=>Job::factory()->create()->id,
            'receiving_work_date'=>$this->faker->date(),
            'contract_period'=>1,
            'contract_type'=>'salary',
            'salary'=>1000.00,
            ];
    }


    //test Update Employee Success
    public function test_update_employee()
    {
        $this->test_create_employee();
        $employeeData = $this->createEmployeeData();
        $employee     = Employee::orderBy('id','desc')->first();
        $response     = $this->actingAsWithPermission('edit-employee')->putJson($this->baseUrl.$employee->id, $employeeData);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'data',
            ]);
    }

    // test Show Employees Data
    public function test_show(){
        $response = $this->actingAsWithPermission('list-employee')->getJson($this->baseUrl);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'data',
            ]);
    }

    // test Make Employee in BlackList
    public function test_black_list(){
        $this->test_create_employee();
        $reason   = ['reason'=>$this->faker->randomLetter(20)];
        $employee = Employee::orderBy('id','desc')->first();
        $response = $this->actingAsWithPermission('edit-employee')->postJson($this->baseUrl.$employee->id.'/blacklist', $reason);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'data',
            ]);
    }



}
