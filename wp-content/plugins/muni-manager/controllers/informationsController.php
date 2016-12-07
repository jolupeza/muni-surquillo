<?php

use Endroid\SimpleExcel\SimpleExcel;

class informationsController extends Controller
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

        $filename = 'solicitudes.xls';

        $title = 'Relación de Solicitudes';

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Solicitudes');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:S1');
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
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);

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
            'A3' => 'Nombres y Apellidos',
            'B3' => 'Tipo de Documento',
            'C3' => 'Número de Documento',
            'D3' => 'Departamento',
            'E3' => 'Provincia',
            'F3' => 'Distrito',
            'G3' => 'Dirección',
            'H3' => 'Urb | AA.HH.',
            'I3' => 'Correo electrónico',
            'J3' => 'Teléfono',
            'K3' => 'Información Solicitada',
            'L3' => 'Unidad Orgánica',
            'M3' => 'Observación',
            'N3' => 'Forma de Entrega',
            'O3' => 'Nombre Rep.',
            'P3' => 'Tip. Doc. Rep.',
            'Q3' => 'Num. Doc. Rep.',
            'R3' => 'Tipo Persona',
            'S3' => 'Fecha'
        );

        return $this->headers;
    }

    private function generateCellsExcel(PHPExcel $excel)
    {
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'informations',
        );

        $i = 4;
        $the_query = new WP_Query($args);

        if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
                $the_query->the_post();

                $id = get_the_ID();
                $values = get_post_custom($id);

                $name = isset($values['mb_name']) ? esc_attr($values['mb_name'][0]) : '';
                $tipdoc = isset($values['mb_tipdoc']) ? (int)esc_attr($values['mb_tipdoc'][0]) : 0;
                $numdoc = isset($values['mb_numdoc']) ? esc_attr($values['mb_numdoc'][0]) : '';
                $dpto = isset($values['mb_dpto']) ? (int)esc_attr($values['mb_dpto'][0]) : 0;
                $prov = isset($values['mb_prov']) ? (int)esc_attr($values['mb_prov'][0]) : 0;
                $dist = isset($values['mb_dist']) ? (int)esc_attr($values['mb_dist'][0]) : 0;
                $via = isset($values['mb_via']) ? esc_attr($values['mb_via'][0]) : '';
                $address = isset($values['mb_address']) ? esc_attr($values['mb_address'][0]) : '';
                $number = isset($values['mb_number']) ? esc_attr($values['mb_number'][0]) : '';
                $urb = isset($values['mb_urb']) ? esc_attr($values['mb_urb'][0]) : '';
                $email = isset($values['mb_email']) ? esc_attr($values['mb_email'][0]) : '';
                $phone = isset($values['mb_phone']) ? esc_attr($values['mb_phone'][0]) : '';
                $infsol = isset($values['mb_infsol']) ? esc_attr($values['mb_infsol'][0]) : '';
                $depend = isset($values['mb_depend']) ? esc_attr($values['mb_depend'][0]) : '';
                $obser = isset($values['mb_obser']) ? esc_attr($values['mb_obser'][0]) : '';
                $namerep = isset($values['mb_namerep']) ? esc_attr($values['mb_namerep'][0]) : '';
                $tipdocrep = isset($values['mb_tipdocrep']) ? (int)esc_attr($values['mb_tipdocrep'][0]) : 0;
                $numdocrep = isset($values['mb_numdocrep']) ? esc_attr($values['mb_numdocrep'][0]) : '';
                $tipper = isset($values['mb_tipper']) ? esc_attr($values['mb_tipper'][0]) : '';

                $dataDpto = get_post($dpto);
                $nameDpto = $dataDpto->post_title;

                $dataProv = get_post($prov);
                $nameProv = $dataProv->post_title;

                $dataDist = get_post($dist);
                $nameDist = $dataDist->post_title;

                $dataTipDoc = get_post($tipdoc);
                $nameTipDoc = $dataTipDoc->post_title;

                $dataTipDocRep = get_post($tipdocrep);
                $nameTipDocRep = $dataTipDocRep->post_title;
                
                $delivery = get_the_terms($id, 'deliveries')[0]->name;

                $excel->getActiveSheet()->setCellValue('A'.$i, $name);
                $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('B'.$i, $nameTipDoc);
                $excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('C'.$i, $numdoc);
                $excel->getActiveSheet()->getStyle('C'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('D'.$i, $nameDpto);
                $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('E'.$i, $nameProv);
                $excel->getActiveSheet()->getStyle('E'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('F'.$i, $nameDist);
                $excel->getActiveSheet()->getStyle('F'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('G'.$i, "$via $address $number");
                $excel->getActiveSheet()->getStyle('G'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('H'.$i, $urb);
                $excel->getActiveSheet()->getStyle('H'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('I'.$i, $email);
                $excel->getActiveSheet()->getStyle('I'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('J'.$i, $phone);
                $excel->getActiveSheet()->getStyle('J'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('K'.$i, $infsol);
                $excel->getActiveSheet()->getStyle('K'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('L'.$i, $depend);
                $excel->getActiveSheet()->getStyle('L'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('M'.$i, $obser);
                $excel->getActiveSheet()->getStyle('M'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('N'.$i, $delivery);
                $excel->getActiveSheet()->getStyle('N'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('O'.$i, $namerep);
                $excel->getActiveSheet()->getStyle('O'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('P'.$i, $nameTipDocRep);
                $excel->getActiveSheet()->getStyle('P'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('Q'.$i, $numdocrep);
                $excel->getActiveSheet()->getStyle('Q'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('R'.$i, $tipper);
                $excel->getActiveSheet()->getStyle('R'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('S'.$i, get_the_time('d-m-Y'));
                $excel->getActiveSheet()->getStyle('S'.$i)->getFont()->setSize(10);

//                $excel->getActiveSheet()->setCellValue('G'.$i, $datePostulation);
//                $excel->getActiveSheet()->getStyle('G'.$i)->getFont()->setSize(10);
//                $excel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                ++$i;
            }
        }
        wp_reset_postdata();
    }
}
