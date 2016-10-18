<?php

use Endroid\SimpleExcel\SimpleExcel;

/**
 * Description of postulantesController.
 *
 * @author jperez
 */
class subscribersController extends Controller
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

        $filename = 'suscriptores.xlsx';

        $title = 'Relación de Suscriptores';
        
        if (!empty($carrera)) {
            $carrera = (int)$carrera;
            $dataCarrera = get_post($carrera);
            
            $filename = "suscriptores-$dataCarrera->post_name.xlsx";
            $title .= " a $dataCarrera->post_title";
        }

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Suscriptores');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);

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
            'C3' => 'Correo electrónico',
            'D3' => 'Teléfono / Celular',
            'E3' => 'Distrito',
            'F3' => 'Carrera',
            'G3' => '¿Cómo se entero?',
        );

        return $this->headers;
    }

    private function generateCellsExcel(PHPExcel $excel, $carrera = '')
    {        
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'subscribers',
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

                $name = (isset($values['mb_name'])) ? esc_attr($values['mb_name'][0]) : '';
                $lastname = (isset($values['mb_lastname'])) ? esc_attr($values['mb_lastname'][0]) : '';
                $email = (isset($values['mb_email'])) ? esc_attr($values['mb_email'][0]) : '';
                $phone = (isset($values['mb_phone'])) ? esc_attr($values['mb_phone'][0]) : '';
                $district = (isset($values['mb_district'])) ? (int)esc_attr($values['mb_district'][0]) : '';
                $carrera = (isset($values['mb_carrera'])) ? (int)esc_attr($values['mb_carrera'][0]) : '';
                
                $know = get_the_terms($id, 'knowsubs');
                
                $nameDistrict = '';
                if (!empty($district)) {
                    $district = get_post($district);
                    $nameDistrict = $district->post_title;
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

                $excel->getActiveSheet()->setCellValue('C'.$i, $email);
                $excel->getActiveSheet()->getStyle('C'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('D'.$i, $phone);
                $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('E'.$i, $nameDistrict);
                $excel->getActiveSheet()->getStyle('E'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('F'.$i, $nameCarrera);
                $excel->getActiveSheet()->getStyle('F'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('G'.$i, $know[0]->name);
                $excel->getActiveSheet()->getStyle('G'.$i)->getFont()->setSize(10);

//                $excel->getActiveSheet()->setCellValue('G'.$i, $datePostulation);
//                $excel->getActiveSheet()->getStyle('G'.$i)->getFont()->setSize(10);
//                $excel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                ++$i;
            }
        }
        wp_reset_postdata();
    }
}
