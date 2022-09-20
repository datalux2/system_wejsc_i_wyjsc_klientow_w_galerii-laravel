<?php
    namespace App\Http\Controllers;
    use App\Models\InputsOutputsModel;
    use App\Models\InputsOutputsHoursModel;
    use Illuminate\Http\Request;

    class StatisticsController extends Controller
    {
        public function chart_statistics()
        {
            $inputs_outputs_model = new InputsOutputsModel();
            
            $inputs_outputs_hours_model = new InputsOutputsHoursModel();
            
            $get_input_camera1 = $inputs_outputs_model->get_input_camera1();
            
            $get_output_camera1 = $inputs_outputs_model->get_output_camera1();
            
            $get_input_camera2 = $inputs_outputs_model->get_input_camera2();
            
            $get_output_camera2 = $inputs_outputs_model->get_output_camera2();
            
            $get_input_global = $inputs_outputs_model->get_input_global();
            
            $get_output_global = $inputs_outputs_model->get_output_global();
            
            $get_count_persons = $inputs_outputs_hours_model->get_count_persons();
            
            $days = $inputs_outputs_hours_model->get_days();
            
            return view('statistics/chart_statistics', [
                'get_input_camera1' => $get_input_camera1,
                'get_output_camera1' => $get_output_camera1,
                'get_input_camera2' => $get_input_camera2,
                'get_output_camera2' => $get_output_camera2,
                'get_input_global' => $get_input_global,
                'get_output_global' => $get_output_global,
                'get_count_persons' => $get_count_persons,
                'days' => $days
            ]);
        }
        
        public function get_chart_statistics_by_day(Request $request)
        {
            if($request->isMethod('post'))
            {
                $day = $request->input('day');
            
                $inputs_outputs_hours_model = new InputsOutputsHoursModel();

                $chart_statistics = $inputs_outputs_hours_model->get_chart_statistics_by_day($day);

                return json_encode($chart_statistics);
            }
        }
    }
?>
