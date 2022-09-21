<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use App\Models\InputsOutputsModel;
    use App\Models\InputsOutputsHoursModel;
    use DB;

    class InputsOutputsHoursModel extends Model
    {   
        /**
        * The table associated with the model.
        *
        * @var string
        */
        protected $table = 'inputs_outputs_hours';
        
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
        
        public function agregate()
        {  
           $date_today = date('Y-m-d');
           
           $hour_today = date('H');
           
           $date_yesterday = date('Y-m-d', strtotime($date_today . ' ' . $hour_today . ':00:00') - 60 * 60);
           
           $hour_yesterday = date('H', strtotime($date_today . ' ' . $hour_today . ':00:00') - 60 * 60);
           
           if (!empty($this->if_datetime_exists($date_yesterday, $hour_yesterday)))
           {
                $this->agregate_db($date_yesterday, $hour_yesterday);
           }
           
           if (!empty($this->if_datetime_exists($date_today, $hour_today)))
           {
                $this->agregate_db($date_today, $hour_today); 
           }
        }
        
        public function if_datetime_exists($date, $hour)
        {  
            $result = InputsOutputsModel::where(DB::raw('date(datetime)'), $date)
                ->where(DB::raw('hour(datetime)'), $hour)
                ->get()->toArray();
           
           return $result;
        }
        
        public function agregate_db($date, $hour)
        {            
            $result2 = InputsOutputsHoursModel::where('date', $date)
                ->where('hour', $hour)
                ->first();

            if(empty($result2))
            {   
                $result3 = $this->get_count_input_output($date, $hour, 1);

                $result4 = $this->get_count_input_output($date, $hour, 0);

                $inputsOutputsHoursModel = new InputsOutputsHoursModel();
                
                $inputsOutputsHoursModel->date = $date;
                $inputsOutputsHoursModel->hour = $hour;
                $inputsOutputsHoursModel->input = $result3['count_input'];
                $inputsOutputsHoursModel->output = $result4['count_output'];

                $inputsOutputsHoursModel->save();
            }
            else
            {
                $result3 = $this->get_count_input_output($result2['date'], $result2['hour'], 1);

                $result4 = $this->get_count_input_output($result2['date'], $result2['hour'], 0);

                $data = [
                     'input' => $result3['count_input'],
                     'output'  => $result4['count_output']
                ];
                 
                InputsOutputsHoursModel::where('date', $result2['date'])
                    ->where('hour', $result2['hour'])
                    ->update($data);
            }
        }
        
        public function get_count_persons()
        {   
            $result = InputsOutputsHoursModel::select(DB::raw('(sum(input) - sum(output)) as count_persons'))
                    ->first();
            
            return $result;
        }
        
        private function get_count_input_output($date, $hour, $direction)
        {
            $result = InputsOutputsModel::select(DB::raw('COUNT(*) ' . (($direction == 1) ? 'count_input': (($direction == 0) ? 'count_output':''))), DB::raw('DATE(datetime) date'), DB::raw('HOUR(datetime) hour'))
                ->where('direction', $direction)
                ->where(DB::raw('DATE(datetime)'), $date)
                ->where(DB::raw('HOUR(datetime)'), $hour)
                ->groupBy('date', 'hour')
                ->get()->toArray();
            
            if(empty($result))
            {
                if ($direction == 1)
                {
                    $result['count_input'] = 0;
                }
                else if ($direction == 0)
                {
                    $result['count_output'] = 0;
                }
            }
            else
            {
                $result = $result[0];
            }
            
            return $result;
        }
        
        public function get_days()
        {   
            $result = InputsOutputsHoursModel::select(DB::raw("DATE_FORMAT(date, '%d-%m-%Y') day, date"))
                ->distinct()
                ->orderBy('date')
                ->get();
            
            return $result;
        }
        
        public function get_chart_statistics_by_day($day)
        {         
            $result = InputsOutputsHoursModel::where('date', $day)
                ->orderBy('date')
                ->orderBy('hour')
                ->get();
            
            return $result;
        }
    }
?>
