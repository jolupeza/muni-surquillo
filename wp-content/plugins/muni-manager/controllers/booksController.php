<?php

use Endroid\SimpleExcel\SimpleExcel;

class booksController extends Controller
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
        echo '';
    }

    public function generateExcel()
    {
        $this->excel = new SimpleExcel();
        $objPHPExcel = new PHPExcel();

        $filename = 'libro-de-reclamaciones.xls';

        $title = 'Relación de Solicitudes';

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Solicitudes');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:L1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);

        $this->generateHeaderExcel($objPHPExcel);
        $this->generateCellsExcel($objPHPExcel);

//        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //mime type XLSX
        header('Content-Type: application/vnd.ms-excel'); //mime type XLS
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
            'A3' => 'Servicio',
            'B3' => 'Área encargada',
            'C3' => 'Mensaje',
            'D3' => 'Nombre',
            'E3' => 'D.N.I.',
            'F3' => 'Correo electrónico',
            'G3' => 'Teléfono',
            'H3' => 'Departamento',
            'I3' => 'Provincia',
            'J3' => 'Distrito',
            'K3' => 'Dirección',
            'L3' => 'Fecha'
        );

        return $this->headers;
    }

    private function generateCellsExcel(PHPExcel $excel)
    {
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'books',
        );

        $i = 4;
        $the_query = new WP_Query($args);

        if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
                $the_query->the_post();

                $id = get_the_ID();
                $values = get_post_custom($id);

                $service = isset($values['mb_service']) ? esc_attr($values['mb_service'][0]) : '';
                $area = isset($values['mb_area']) ? esc_attr($values['mb_area'][0]) : '';
                $message = isset($values['mb_message']) ? esc_attr($values['mb_message'][0]) : '';
                $file = isset($values['mb_file']) ? esc_attr($values['mb_file'][0]) : '';

                $name = isset($values['mb_name']) ? esc_attr($values['mb_name'][0]) : '';
                $dni = isset($values['mb_dni']) ? esc_attr($values['mb_dni'][0]) : '';
                $email = isset($values['mb_email']) ? esc_attr($values['mb_email'][0]) : '';
                $phone = isset($values['mb_phone']) ? esc_attr($values['mb_phone'][0]) : '';

                $dpto = isset($values['mb_dpto']) ? (int)esc_attr($values['mb_dpto'][0]) : 0;
                $prov = isset($values['mb_prov']) ? (int)esc_attr($values['mb_prov'][0]) : 0;
                $dist = isset($values['mb_dist']) ? (int)esc_attr($values['mb_dist'][0]) : 0;

                $via = isset($values['mb_via']) ? esc_attr($values['mb_via'][0]) : '';
                $address = isset($values['mb_address']) ? esc_attr($values['mb_address'][0]) : '';
                $number = isset($values['mb_number']) ? esc_attr($values['mb_number'][0]) : '';

                $dataDpto = get_post($dpto);
                $nameDpto = $dataDpto->post_title;

                $dataProv = get_post($prov);
                $nameProv = $dataProv->post_title;

                $dataDist = get_post($dist);
                $nameDist = $dataDist->post_title;

                $excel->getActiveSheet()->setCellValue('A'.$i, $service);
                $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('B'.$i, $area);
                $excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('C'.$i, $message);
                $excel->getActiveSheet()->getStyle('C'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('D'.$i, $name);
                $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('E'.$i, $dni);
                $excel->getActiveSheet()->getStyle('E'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('F'.$i, $email);
                $excel->getActiveSheet()->getStyle('F'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('G'.$i, $phone);
                $excel->getActiveSheet()->getStyle('G'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('H'.$i, $nameDpto);
                $excel->getActiveSheet()->getStyle('H'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('I'.$i, $nameProv);
                $excel->getActiveSheet()->getStyle('I'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('J'.$i, $nameDist);
                $excel->getActiveSheet()->getStyle('J'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('K'.$i, "$via $address $number");
                $excel->getActiveSheet()->getStyle('K'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('L'.$i, get_the_time('d-m-Y'));
                $excel->getActiveSheet()->getStyle('L'.$i)->getFont()->setSize(10);

//                $excel->getActiveSheet()->setCellValue('G'.$i, $datePostulation);
//                $excel->getActiveSheet()->getStyle('G'.$i)->getFont()->setSize(10);
//                $excel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                ++$i;
            }
        }
        wp_reset_postdata();
    }
}
