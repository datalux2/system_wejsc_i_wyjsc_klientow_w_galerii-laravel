<?php
    namespace App\Http\Controllers;

    class CronController extends Controller
    {
        public function count_random_input_output()
        {
            $inputs_outputs_model = new \App\Models\InputsOutputsModel;
            
            $inputs_outputs_model->random();
            
            return view('cron/count_random_input_output');
        }
    }
?>
