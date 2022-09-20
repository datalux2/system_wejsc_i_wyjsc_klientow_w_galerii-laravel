<?php
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Model;
    use App\Models\InputsOutputsModel;
    use DB;
    
    class InputsOutputsModel extends Model
    {
        /**
        * The table associated with the model.
        *
        * @var string
        */
        protected $table = 'inputs_outputs';
        
        /**
        * The primary key associated with the table.
        *
        * @var string
        */
        protected $primaryKey = 'id';
        
        /**
        * Indicates if the model's ID is auto-incrementing.
        *
        * @var bool
        */
        public $incrementing = true;
        
        /**
        * Indicates if the model should be timestamped.
        *
        * @var bool
        */
        public $timestamps = false;
        
        /**
        * The storage format of the model's date columns.
        *
        * @var string
        */
        protected $dateFormat = 'Y-m-d H:i:s';
        
        public function random()
        {   
            for($i = 1; $i <= 5; $i++)
            {
                $inputsOutputsHoursModel = new InputsOutputsHoursModel();
                
                $result = $inputsOutputsHoursModel->get_count_persons();
                
                $count_persons = (int)$result['count_persons'];
                
                if($count_persons > 0)
                {
                    $direction = random_int(0, 1);
                }
                else if ($count_persons == 0)
                {
                    $direction = 1;
                }

                $camera_number = random_int(1, 2);

                $inputsOutputsModel = new InputsOutputsModel;
                $inputsOutputsModel->datetime = date('Y-m-d H:i:s');
                $inputsOutputsModel->direction = $direction;
                $inputsOutputsModel->camera_number = $camera_number;
                
                $inputsOutputsModel->save();
                
                $inputs_outputs_hours_model = new InputsOutputsHoursModel;
            
                $inputs_outputs_hours_model->agregate();
            }
        }
        
        public function get_input_camera1()
        {   
            $result = InputsOutputsModel::select(DB::raw('count(*) as count_wejsc'))
                ->where('direction', 1)
                ->where('camera_number', 1)
                ->first();
            
            return $result;
        }
        
        public function get_output_camera1()
        {   
            $result = InputsOutputsModel::select(DB::raw('count(*) as count_wyjsc'))
                ->where('direction', 0)
                ->where('camera_number', 1)
                ->first();
            
            return $result;
        }
        
        public function get_input_camera2()
        {   
            $result = InputsOutputsModel::select(DB::raw('count(*) as count_wejsc'))
                ->where('direction', 1)
                ->where('camera_number', 2)
                ->first();
            
            return $result;
        }
        
        public function get_output_camera2()
        {   
            $result = InputsOutputsModel::select(DB::raw('count(*) as count_wyjsc'))
                ->where('direction', 0)
                ->where('camera_number', 2)
                ->first();
            
            return $result;
        }
        
        public function get_input_global()
        {   
            $result = InputsOutputsModel::select(DB::raw('count(*) as count_wejsc'))
                ->where('direction', 1)
                ->first();
            
            return $result;
        }
        
        public function get_output_global()
        {   
            $result = InputsOutputsModel::select(DB::raw('count(*) as count_wyjsc'))
                ->where('direction', 0)
                ->first();
            
            return $result;
        }
    }
?>
