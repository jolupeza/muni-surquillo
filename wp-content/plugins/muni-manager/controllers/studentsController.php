<?php

use Endroid\SimpleExcel\SimpleExcel;

/**
 * Description of studentsController.
 *
 * @author jperez
 */
class studentsController extends Controller
{
    private $excel;
    private $headers;

    public function __construct()
    {
        parent::__construct();
        $this->headers = array();
    }

    public function index()
    {
        echo 'hola mundo';
    }

    public function generateExcel($carrera = '')
    {        
        $this->excel = new SimpleExcel();
        $objPHPExcel = new PHPExcel();

        $filename = 'alumnos.xlsx';

        $title = 'Relación de Alumnos';
        
        if (!empty($carrera)) {
            $carrera = (int)$carrera;
            $dataCarrera = get_post($carrera);
            
            $filename = "alumnos-$dataCarrera->post_name.xlsx";
            $title .= " a $dataCarrera->post_title";
        }

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Alumnos');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:N1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(25);

        $this->generateHeaderExcel($objPHPExcel);
        $this->generateCellsExcel($objPHPExcel, $carrera);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //mime type XLSX
//        header('Content-Type: application/vnd.ms-excel'); //mime type XLS
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

//        $this->excel->loadFromArray(array('Postulantes' => $data));
//        $this->excel->saveToOutput($filename, array('Postulantes'));
    }

    private function generateHeaderExcel(PHPExcel $excel)
    {
        $headers = $this->setHeaders();

        if (count($headers)) {
            foreach ($headers as $key => $value) {
                $excel->getActiveSheet()->setCellValue($key, $value);
                $excel->getActiveSheet()->getStyle($key)->getFont()->setSize(11);
                $excel->getActiveSheet()->getStyle($key)->getFont()->setBold(true);
                $excel->getActiveSheet()->getStyle($key)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
        }
    }

    private function setHeaders()
    {
        $this->headers = array(
            'A3' => 'Nombres',
            'B3' => 'Apellidos',
            'C3' => 'DNI o CE',
            'D3' => 'Distrito',
            'E3' => 'Correo electrónico',
            'F3' => 'Teléfono / Celular',
            'G3' => 'Carrera',
            'H3' => 'Trabaja (Si / No)',
            'I3' => 'Centro de Trabajo',
            'J3' => 'Cargo',
            'K3' => 'Distrito de Trabajo',
            'L3' => '¿Quién hará los pagos?',
            'M3' => '¿Qué tipo de comprobante?',
            'N3' => '¿Cómo se entero?',
        );

        return $this->headers;
    }

    private function generateCellsExcel(PHPExcel $excel, $carrera = '')
    {        
        $whopayArr = array('1' => 'Yo mismo', '2' => 'Mis Padres o Apoderados', '3' => 'La empresa donde laboro');
        $voucherArr = array('1' => 'Boleta', '2' => 'Factura');
  
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'students',
        );
        
        if (!empty($carrera)) {
            $carrera = (int)$carrera;
            $args['meta_query'] = [
                [
                    'key' => 'mb_carrera',
                    'value' => $carrera
                ]                
            ];
        }
        
        $i = 4;
        $the_query = new WP_Query($args);

        if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
                $the_query->the_post();

                $id = get_the_ID();
                $values = get_post_custom($id);
                
                $name = isset($values['mb_name']) ? esc_attr($values['mb_name'][0]) : '';
                $lastname = isset($values['mb_lastname']) ? esc_attr($values['mb_lastname'][0]) : '';
                $dni = isset($values['mb_dni']) ? esc_attr($values['mb_dni'][0]) : '';
                $district = isset($values['mb_district']) ? (int)esc_attr($values['mb_district'][0]) : '';
                $email = isset($values['mb_email']) ? esc_attr($values['mb_email'][0]) : '';
                $phone = isset($values['mb_phone']) ? esc_attr($values['mb_phone'][0]) : '';
                $carrera = isset($values['mb_carrera']) ? (int)esc_attr($values['mb_carrera'][0]) : '';
                $work = isset($values['mb_work']) ? esc_attr($values['mb_work'][0]) : '';
                $centerwork = isset($values['mb_centerwork']) ? esc_attr($values['mb_centerwork'][0]) : '';
                $job = isset($values['mb_job']) ? esc_attr($values['mb_job'][0]) : '';
                $districtwork = isset($values['mb_districtwork']) ? (int)esc_attr($values['mb_districtwork'][0]) : '';
                $whopay = isset($values['mb_whopay']) ? esc_attr($values['mb_whopay'][0]) : '';
                $voucher = isset($values['mb_voucher']) ? esc_attr($values['mb_voucher'][0]) : '';
                
                $know = get_the_terms($id, 'know');
                
                $nameDistrict = '';
                if (!empty($district)) {
                    $district = get_post($district);
                    $nameDistrict = $district->post_title;
                }
                
                $nameDistrictWork = '';
                if (!empty($districtwork)) {
                    $districtwork = get_post($districtwork);
                    $nameDistrictWork = $districtwork->post_title;
                }
                
                $nameCarrera = '';
                if (!empty($carrera)) {
                    $carrera = get_post($carrera);
                    $nameCarrera = $carrera->post_title;
                }

                $excel->getActiveSheet()->setCellValue('A'.$i, $name);
                $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('B'.$i, $lastname);
                $excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('C'.$i, $dni);
                $excel->getActiveSheet()->getStyle('C'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('D'.$i, $nameDistrict);
                $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('E'.$i, $email);
                $excel->getActiveSheet()->getStyle('E'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('F'.$i, $phone);
                $excel->getActiveSheet()->getStyle('F'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('G'.$i, $nameCarrera);
                $excel->getActiveSheet()->getStyle('G'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('H'.$i, $work);
                $excel->getActiveSheet()->getStyle('H'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('I'.$i, $centerwork);
                $excel->getActiveSheet()->getStyle('I'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('J'.$i, $job);
                $excel->getActiveSheet()->getStyle('J'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('K'.$i, $nameDistrictWork);
                $excel->getActiveSheet()->getStyle('K'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('L'.$i, $whopayArr[$whopay]);
                $excel->getActiveSheet()->getStyle('L'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('M'.$i, $voucherArr[$voucher]);
                $excel->getActiveSheet()->getStyle('M'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('N'.$i, $know[0]->name);
                $excel->getActiveSheet()->getStyle('N'.$i)->getFont()->setSize(10);
                

//                $excel->getActiveSheet()->setCellValue('G'.$i, $datePostulation);
//                $excel->getActiveSheet()->getStyle('G'.$i)->getFont()->setSize(10);
//                $excel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                ++$i;
            }
        }
        wp_reset_postdata();
    }
}
